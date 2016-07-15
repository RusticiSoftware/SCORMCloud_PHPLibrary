<?php

use RusticiSoftware\ScormContentPlayer\api\model as model;
use RusticiSoftware\Engine\Client as client;

require_once '../ICourseService.php';
require_once '../CourseData.php';
require_once (dirname(__FILE__) . '/apilib/ScormEngineClient.php');
require_once (dirname(__FILE__) . '/APIMappings.php');


class CourseServiceToCourseApiAdapter implements ICourseService
{
	private $configuration;
	private $courseApiClient;
    private $attributeApiToLwsNameMap;
    private $attributeApiToLwsValueMap;
    private $attributeLwsToApiNameMap;
    private $attributeLwsToApiValueMap;

    const MAX_COURSE_LIST_CALLS = 10;

    function __construct($configuration)
    {
        //print_R($configuration);
        $this->configuration = $configuration;
        $scormEngineApiClient = new client\ScormEngineClient($configuration->getScormEngineServiceUrl(),
                                                          $configuration->getApiUsername(),
                                                          $configuration->getApiPassword(),
                                                          $configuration->getTenant());

        $this->courseApiClient = $scormEngineApiClient->GetCoursesApiClient();

        $this->attributeApiToLwsNameMap = APIMappings::getAttributeApiToLwsNameMap();
        $this->attributeLwsToApiNameMap = APIMappings::getAttributeLwsToApiNameMap();
        $this->attributeApiToLwsValueMap = APIMappings::getAttributeApiToLwsValueMap();
        $this->attributeLwsToApiValueMap = APIMappings::getAttributeLwsToApiValueMap();
    }

    /// Import a SCORM .pif (zip file) from the local filesystem.
    /// </summary>
    /// <param name="courseId">Unique Identifier for this course.</param>
    /// <param name="absoluteFilePathToZip">Full path to the .zip file</param>
    /// <param name="itemIdToImport">@deprecated : ID of manifest item to import. If null, root organization is imported</param>
    /// <returns>List of Import Results</returns>
	function ImportCourse($courseId, $absoluteFilePathToZip, $itemIdToImport = null)
	{

        $pathParts = pathinfo($absoluteFilePathToZip);
        $multiPart = new model\multiPart($pathParts["dirname"], basename($absoluteFilePathToZip));

        $importResult = $this->courseApiClient->postCoursesImportJobsByCourseByMayCreateNewVersionByEntitymultiPart($courseId, true, $multiPart);
        $apiImportResult = null;
        do
        {
            usleep(500000);
            $apiImportResult  = $this->courseApiClient->getCoursesImportJobsByImportJobId($importResult->result);
            if($apiImportResult->status == model\status::ERROR)
            {
                break;
            }
            else if($apiImportResult->status == model\status::COMPLETE)
            {
                break;
            }
            //else we are still running, look again.
        } while(true);

        $importResult = new ImportResult(null);
        $importResult->ConvertAPIImportResult($apiImportResult->courseTitle,
            $apiImportResult->message,
            $apiImportResult->status == model\status::COMPLETE,
            $apiImportResult->parserWarnings);

        $allResults = array();
        array_push($allResults, $importResult);
        return $allResults;
	}

    /// <summary>
    /// Import a SCORM .pif (zip file) from an existing .zip file on the
    /// Hosted SCORM Engine server.
    /// </summary>
    /// <param name="courseId">Unique Identifier for this course.</param>
    /// <param name="path">The relative path for the file within your web application
    /// where the zip file for importing can be found</param>
    /// <param name="permissionDomain">@deprecated (not used):An permission domain to associate this course with,
    /// <returns>List of Import Results</returns>
	function ImportUploadedCourse($courseId, $path, $permissionDomain = null)
	{
        $realPath = realpath($path);
        $apiImportResult = $this->ImportCourse($courseId, $realPath );
        return $apiImportResult;
	}

    /// <summary>
    /// Check the existence of a course with the given courseId
    /// </summary>
    /// <param name="courseId">courseId of the course to check for</param>
    /// <returns>boolean value</returns>
    function Exists($courseId)
	{
        try {
            $title = $this->courseApiClient->getCourseTitleByCourseId($courseId);
        }
        catch(Exception $ex){
            $title = "";
        }
        return $title !== "";
	}

    /// <summary>
    /// Retrieve a list of high-level data about all courses.
    /// </summary>
    /// <param name="courseIdFilterRegex">Regular expression to filter the courses by ID</param>
    /// <returns>List of Course Data objects</returns>
	function GetCourseList($courseIdFilterRegex = null)
	{
        $maxCount = 0;
        $more = null;
        $courseList = array();

        $courseListSchema = $this->courseApiClient->getCourses();
        do {
            //parse the url that is return from newer api
            //so that we can get the continuation token (more=)
            //and continue another call after this one (if there is more).
            $parts = parse_url($courseListSchema->more);
            $more = null;
            if(array_key_exists("query",$parts))
            {
                parse_str($parts['query'], $query);
                $more = $query['more'];
            }

            //loop thru the courses that are returned.
            foreach ($courseListSchema->courses as $course)
            {
                $id = $course->id;
                $title = $course->title;
                if(isset($courseIdFilterRegex)){
                    if(!preg_match($courseIdFilterRegex,$id)){
                        continue;
                    }
                }


                //since this method was aggregating
                //courses we shall keep a hash if we've already
                //process the course, since there is
                //no registration count returned just set to -1.
                //var_dump($course);
                if (!array_key_exists($id, $courseList)) {
                    $courseData = new CourseData(null);
                    $courseData = $courseData->BuildFromAPI($id, 1, $course->registrationCount,$title);
                    $courseList[$id] = $courseData;
                }

                //count the versions for the given course.
                $version = $courseList[$id]->getNumberOfVersions()+1;
                $courseList[$id]->setVersions($version);
            }

            //count number of calls we are making
            // to the newer api, we don't want to exceed
            //the max count (see while condition below).
            $maxCount++;

            //if there are more courses to get, then get them
            //note we stop after the number of calls exceeds
            //the MAX_COURSE_LIST_CALLS calls (don't want to kill the server).
            if(!is_null($more))
            {
                $courseListSchema = $this->courseApiClient->getCoursesBySinceByMore('1900-01-17T00:00:00+00:00', $more);
            }
        }while($more != null && $maxCount <= self::MAX_COURSE_LIST_CALLS);


        //if there were more, then the last data item that came back, could have the wrong version count.
        //so we remove said element. (pop removes last element of an array).
        //if(!@is_null($more))
        //{
        //    array_pop($courseList);
        //}
        //var_dump($courseList);
        return array_values($courseList);
	}

    /// <summary>
    /// Delete the specified course
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="deleteLatestVersionOnly">If false, all versions are deleted</param>
    function DeleteCourse($courseId, $deleteLatestVersionOnly = False)
	{

        if($deleteLatestVersionOnly === true || $deleteLatestVersionOnly === "true")
        {
            $versionResult = $this->courseApiClient->getCourseLastVersionByCourseId($courseId);
           $this->courseApiClient->deleteCourseByCourseIdByVersion($courseId, $versionResult->result);
        }
        else
        {
            $this->courseApiClient->deleteCourseByCourseId($courseId);
        }
        return '<?xml version="1.0" encoding="utf-8" ?>' . "\n" . '<rsp stat="ok"><success /></rsp>';
    }

    /// <summary>
    /// Delete the specified version of a course
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="versionId">Specific version of course to delete</param>
    function DeleteCourseVersion($courseId, $versionId)
    {
        $this->courseApiClient->deleteCourseByCourseIdByVersion($courseId, $versionId);
        return '<?xml version="1.0" encoding="utf-8" ?>' . "\n" . '<rsp stat="ok"><success /></rsp>';
    }

    /// <summary>
    /// Get the Course Details in XML Format
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
	function GetCourseDetail($courseId)
	{

        $courseListSchema = $this->courseApiClient->getCourseByCourseId($courseId);
        $firstTime = true;
        $courseXml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><rsp stat="ok"></rsp>');
        $courseChild = null;
        $versionsChild = null;
        $versionCount = 0;
        $regCount = 0;
        $lwsLearningStandard = "";
        //var_dump($detailResult);
        $more = null;

        do {
            //parse the url that is return from newer api
            //so that we can get the continuation token (more=)
            //and continue another call after this one (if there is more).
            $more = $this->ExtractMore($courseListSchema);

            foreach ($courseListSchema->courses as $course) {
                $versionChild = null;
                $dateChild = null;
                if ($firstTime) {
                    $courseChild = $courseXml->addChild('course');
                    $courseChild->addAttribute("id", $course->id);
                    $courseChild->addAttribute("title", $course->title);
                    
                    $versionsChild = $courseChild->addChild("versions");
                    $regCount = $course->registrationCount;

                    //get the mapping for the learning standard.
                    $lwsLearningStandard = APIMappings::getLwsLearningStandardTextFromApiValue($course->courseLearningStandard);
                    $firstTime = false;
                }
                $versionChild = $versionsChild->addChild("version");
                APIMappings::addCData("versionId", $course->version, $versionChild);
                APIMappings::addCData("updateDate", $course->updated, $versionChild);
                $versionCount++;
            }
            //if there are more course versions to get, then get them
            if(!is_null($more)){
                $courseListSchema = $this->courseApiClient->getCourseByCourseIdBySinceByMore($courseId,'1900-01-17T00:00:00+00:00', $more);
            }
        }while($more != null);

        $courseChild->addAttribute("versions", $versionCount);
        $courseChild->addAttribute("registrations", $regCount);
        $courseChild->addAttribute("size", "0");
        $courseChild->addChild("tags");
        //$courseChild->addChild("learningStandard","<![CDATA[" . $lwsLearningStandard . "]]>");
        APIMappings::addCData("learningStandard", $lwsLearningStandard , $courseChild);

        return $courseXml->asXML();
	}

    /// <summary>
    /// Get the url that can be opened in a browser and used to preview this course, without
    /// the need for a registration.
    /// </summary>
    /// <param name="courseId">Unique Course Identifier</param>
    /// <param name="redirectOnExitUrl">Where to redirect after closeing the preview window.</param>
    /// <param name="cssUrl">@deprecated : no longer used.</param>
    function GetPreviewUrl($courseId, $redirectOnExitUrl, $cssUrl = null)
	{
        $previewUrl = $this->courseApiClient->getCoursePreviewByCourseIdByExpiryByForceReviewByStartScoByRedirectOnExitUrl($courseId,0,false,"",$redirectOnExitUrl);

        //get the 2015 api url, and parse so we can add it to the return relative url.
        $engineUrl = $this->GetEngineServerUrl();
        return "$engineUrl$previewUrl->launchLink";
	}

    /// <summary>
    /// Gets the url to view/edit the package properties for this course.  Typically
    /// used within an IFRAME
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <returns>URL to package property editor</returns>
    /// <param name="notificationFrameUrl"> @deprecated no longer used</param>
	function GetPropertyEditorUrl($courseId, $stylesheetUrl, $notificationFrameUrl)
	{
        $result = $this->courseApiClient->getCoursePackagePropertiesLinkByCourseIdByCssUrl($courseId, $stylesheetUrl);
        $engineUrl = $this->GetEngineServerUrl();
        return "$engineUrl$result->link";
	}

    /// <summary>
    /// Get the url that can be targeted by a form to upload and import a course into SCORM Cloud
    /// </summary>
    /// <param name="courseId">Unique Course Identifier</param>
    /// <param name="redirectUrl">the url location the browser will be redirected to when the import is finished</param>
	function GetImportCourseUrl($courseId, $redirectUrl)
	{
        try{
            $result = $this->courseApiClient->getCoursesImportLinkByCourseByRedirectUrl($courseId, $redirectUrl);
            $engineUrl = $this->GetEngineServerUrl();
            return "$engineUrl$result->link";
        }catch(Exception $ex){
            error_log($ex->getMessage());
            return "";
        }
	}

    /// <summary>
    /// Retrieve the list of course attributes associated with a specific version
    /// of the specified course.
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="versionId">Specific version the specified course</param>
    /// <returns>Dictionary of all attributes associated with this course</returns>
	function GetAttributes($courseId, $versionId = Null)
	{
        $apiAttributes = null;
        if(is_null($versionId))
            $apiAttributes = $this->courseApiClient->getCourseConfigurationByCourseId($courseId);
        else
            $apiAttributes = $this->courseApiClient->getCourseConfigurationByCourseIdByVersion($courseId, $versionId);

        //var_dump($apiAttributes);

        //need to build an array of what is expected for localws.
        $debugAttributes = array();
        $lwsAttributes = array();
        foreach ($apiAttributes->configurationItems as $apiAttribute)
        {
            //echo($apiAttribute->id . "|");
            if(array_key_exists($apiAttribute->id, $this->attributeApiToLwsNameMap))
            {
                if(array_key_exists($apiAttribute->id,$this->attributeApiToLwsValueMap) || APIMappings::IsAnApiDebugAttribute($apiAttribute->id))
                {
                    //if it's a debug value we'll have to process after we
                    //have collected all the flags. since it's a many to one type
                    //mapping.
                    if(APIMappings::IsAnApiDebugAttribute($apiAttribute->id)){
                        $debugAttributes[$apiAttribute->id] = $apiAttribute->value;
                    }
                    else
                    {
                        $lwsName = $this->attributeApiToLwsNameMap[$apiAttribute->id];
                        $lwsValue = APIMappings::MapApiValueToLwsValue($apiAttribute->id, $apiAttribute->value);

                        $xml = new SimpleXMLElement("<attribute></attribute>");
                        $xml->addAttribute('name', $lwsName);
                        $xml->addAttribute('value', $lwsValue);
                        $lwsAttributes[$lwsName] = $xml["value"];
                    }
                }
                else
                {
                    //$lwsAttributes[$lwsName] = $lwsValue;
                    throw new \Exception("Unknown value map");
                }
            }
        }

        //next we need to map the debug attributes,
        //since these are really many to one mappings,
        //eg PlayerDebugControlAudit=true goes to detail => debugControl = "audit"
        //eg PlayerDebugControlDetailed=true goes to detail => debugControl = "Detail"
        //thus this mapping is a little different than just an one to one mapping.
        $debugMapped = APIMappings::MapDebugApiValuesToLws($debugAttributes);
        $lwsAttributes = array_merge($lwsAttributes,$debugMapped);

        //we also need to get the scorm version and the course title, these are not
        //attributes of the course but are in the course def.
        $result = $this->courseApiClient->getCourseTitleByCourseId($courseId);
        $xml = new SimpleXMLElement("<attribute></attribute>");
        $xml->addAttribute('name', "title");
        $xml->addAttribute('value', $result->title);
        $lwsAttributes["title"] = $xml["value"];

        $result = $this->courseApiClient->getCourseByCourseId($courseId);
        //var_dump($result);
        //scorm version.
        $lastCourse = $result->courses[count($result->courses)-1];
        $lwsLearningStandard = APIMappings::GetLwsLearningStandardFromApiValue($lastCourse->courseLearningStandard);
        $xml = new SimpleXMLElement("<attribute></attribute>");
        $xml->addAttribute('name', "scormVersion");
        $xml->addAttribute('value', $lwsLearningStandard);
        $lwsAttributes["scormVersion"] = $xml["value"];


        ksort($lwsAttributes);
        return $lwsAttributes;
	}

    /// <summary>
    /// Update the specified attributes (name/value pairs)
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="versionId">Specific version the specified course</param>
    /// <param name="attributePairs">Map of name/value pairs</param>
    /// <returns>Dictionary of changed attributes</returns>
    function UpdateAttributes($courseId, $versionId, $attributePairs)
	{
        //check to make sure we are updating the latest version,
        //because the api only supports updating the latest version.
        if(isset($versionId))
        {
            $versionResult = $this->courseApiClient->getCourseLastVersionByCourseId($courseId);
            if($versionResult->result !== (string)$versionId)
            {
                throw new Exception("Current API does not support updating a specific course version attribute");
            }
        }

        $returnValues = array();
        foreach ($attributePairs as $key => $value)
        {
            //$params[$key] = $value;
            //lookup the mapped version of the localws name to get
            //the 2015 api name.
            if(array_key_exists($key,$this->attributeLwsToApiValueMap) || APIMappings::IsAnLwsDebugAttribute($key))
            {

                //first check if this an lws debug attribute.
                //because it's  combination of the name+value
                //that equal one to many api keys.
                if (APIMappings::IsAnLwsDebugAttribute($key))
                {
                    $apiDebugFlags = APIMappings::MapDebugLwsValuesToApi($key,$value);
                    foreach($apiDebugFlags as $apiNameKey => $apiValue)
                    {
                        $apiEntity = new model\settingSchema();
                        $apiEntity->value = $apiValue;
                        $this->courseApiClient->putCourseConfigurationBySettingIdByCourseIdByEntitysettingSchema($apiNameKey, $courseId, $apiEntity);
                    }
                }
                else
                {
                    $apiName = $this->attributeLwsToApiNameMap[$key];
                    $apiValue = APIMappings::MapLwsValueToApiValue($key, $value);

                    $apiEntity = new model\settingSchema();
                    $apiEntity->value = $apiValue;
                    $this->courseApiClient->putCourseConfigurationBySettingIdByCourseIdByEntitysettingSchema($apiName, $courseId, $apiEntity);
                }
            }
            $xmlValueElement = new SimpleXMLElement("<value>" . $value . "</value>");
            $returnValues[$key] = $xmlValueElement;
        }
        return $returnValues;
	}

    //****************************************************
    //not supported functions:
    //****************************************************
    /// <summary>
    /// @deprecated function no longer used.
    /// Get the Course Metadata in XML Format
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="versionId">Version of the specified course</param>
    /// <param name="scope">Defines the scope of the data to return: Course or Activity level</param>
    /// <param name="format">Defines the amount of data to return:  Summary or Detailed</param>
    /// <returns>XML string representing the Metadata</returns>
    function GetMetadata($courseId, $versionId, $scope, $format)
    {
        throw new \Exception("Current API does not support GetMetadata()");
    }

    /// <summary>
    /// @deprecated function no longer used.
    /// </summary>
    function GetUpdateAssetsUrl($courseId, $redirectUrl)
    {
        throw new \Exception("Current API does not support GetUpdateAssetsUrl()");
    }

    /// <summary>
    /// @deprecated function no longer used.
    /// Update the assets of the specified course
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="uploadLocation">The relative path to the uploaded zip file</param>
	function UpdateAssetsFromUploadedFile($courseId, $uploadLocation)
	{
        throw new \Exception("Current API does not support UpdateAssetsFromUploadedFile()");
	}
    //****************************************************
    //end of not supported functions.
    //****************************************************

    //private helper functions.
    private function ExtractMore($courseListSchema)
    {
        $parts = parse_url($courseListSchema->more);
        //var_dump($courseListSchema->more);
        $more = null;
        if (array_key_exists("query", $parts)) {
            parse_str($parts['query'], $query);
            $more = $query['more'];
            return $more;
        }
        return $more;
    }
    private function GetEngineServerUrl(){
        $parsed_url = parse_url($this->configuration->getScormEngineServiceUrl());
        $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
        $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
        return "$scheme$host$port";
    }

}
