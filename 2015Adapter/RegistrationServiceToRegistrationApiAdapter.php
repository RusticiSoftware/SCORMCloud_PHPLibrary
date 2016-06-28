<?php

use RusticiSoftware\ScormContentPlayer\api\model as model;
use RusticiSoftware\Engine\Client as client;

require_once '../RegistrationData.php';
require_once '../RegistrationSummary.php';
require_once '../ICourseService.php';
require_once (dirname(__FILE__) . '/apilib/ScormEngineClient.php');
require_once (dirname(__FILE__) . '/APIMappings.php');
require_once '../IRegistrationService.php';

class RegistrationServiceToRegistrationApiAdapter implements IRegistrationService
{
	private $configuration;
	private $registrationApiClient;
    private $courseApiClient;
    private $attributeApiToLwsNameMap;
    private $attributeApiToLwsValueMap;
    private $attributeLwsToApiNameMap;
    private $attributeLwsToApiValueMap;

    const DEFAULT_DATE = '1900-01-17T00:00:00+00:00';

    const MAX_REG_API_CALL = 2;

    function __construct($configuration)
    {
        $this->configuration = $configuration;

        $scormEngineApiClient = new client\ScormEngineClient($configuration->getScormEngineServiceUrl(),
                                                          $configuration->getApiUsername(),
                                                          $configuration->getApiPassword(),
                                                          $configuration->getTenant());

        $this->registrationApiClient = $scormEngineApiClient->GetRegistrationsApiClient();
        $this->courseApiClient = $scormEngineApiClient->GetCoursesApiClient();

        $this->attributeApiToLwsNameMap = APIMappings::getAttributeApiToLwsNameMap();
        $this->attributeLwsToApiNameMap = APIMappings::getAttributeLwsToApiNameMap();
        $this->attributeApiToLwsValueMap = APIMappings::getAttributeApiToLwsValueMap();
        $this->attributeLwsToApiValueMap = APIMappings::getAttributeLwsToApiValueMap();
    }

    /// <summary>
    /// Create a new Registration (Instance of a user taking a course)
    /// </summary>
    /// <param name="registrationId">Unique Identifier for the registration</param>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="learnerId">Unique Identifier for the learner</param>
    /// <param name="learnerFirstName">Learner's first name</param>
    /// <param name="learnerLastName">Learner's last name</param>
    /// <param name="email">@deprecated use the learner's id instead.</param>
    /// <param name="email">@deprecated use the learner's id instead.</param>
    /// <param name="resultsformat">@deprecated not used.</param>
    /// <param name="resultsPostbackUrl">your endpoint that engine will call for posting events (a webhook)</param>
    /// <param name="postBackLoginName">your endpoint's username to use for security</param>
    /// <param name="postBackLoginPassword">your endpoint's password to use for security</param>
    /// <param name="versionId">@deprecated this is not used, versions will be auto-incremented in engine.</param>
    public function CreateRegistration($registrationId,
                                       $courseId,
                                       $learnerId,
                                       $learnerFirstName,
                                       $learnerLastName,
                                       $email = null,
                                       $authtype = null,
                                       $resultsformat = 'xml',
                                       $resultsPostbackUrl = null,
                                       $postBackLoginName = null,
                                       $postBackLoginPassword = null,
                                       $versionId = null)
    {
        $newReg = new model\registrationSchema();
        $newReg->registrationId = $registrationId;
        $newReg->courseId = $courseId;

        $newReg->learner = new model\learnerSchema();
        $newReg->learner->id = $learnerId;
        $newReg->learner->firstName = $learnerFirstName;
        $newReg->learner->lastName = $learnerLastName;

        $newReg->postBack = new model\postBack();
        $newReg->postBack->authType = strtolower($authtype) === "httpbasic" ?  model\authType::HTTPBASIC : model\authType::FORM;
        $newReg->postBack->url = $resultsPostbackUrl;
        $newReg->postBack->userName = $postBackLoginName;
        $newReg->postBack->password = $postBackLoginPassword;

        $this->registrationApiClient->postRegistrationsByEntityregistrationSchema($newReg);
        return '<?xml version="1.0" encoding="utf-8" ?>' . "\n" . '<rsp stat="ok"><success /></rsp>';
    }

    /// <summary>
    /// Returns the current state of the registration, including completion
    /// and satisfaction type data.  Amount of detail depends on format parameter.
    /// </summary>
    /// <param name="registrationId">Unique Identifier for the registration</param>
    /// <param name="resultsFormat">Degree of detail to return, 0 for course, 1 for activity, 2 for full.</param>
    /// <param name="dataFormat">@deprecated (only option is xml) Registration data in XML Format</param>
    public function GetRegistrationResult($registrationId, $resultsFormat, $dataFormat)
    {
        $rspXml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><rsp stat="ok"></rsp>');
        //$listXml = $rspXml->addChild("registrationlist");

        //map to hold registrations above the "instances" (or other words non-instances.
        $lwsRegistrationMap = $this->getRegistrationApiResultByRegistrationId($registrationId);

        foreach($lwsRegistrationMap as $lwsMap)
        {

            //build the Registration Detail section.
            //$regTag = $this->BuildRegistrationDetail($listXml, $lwsMap);

            //next we must get the activity detail for this last registration instance.
            $activityResult = $this->registrationApiClient->getRegistrationProgressDetailByRegistrationIdByInstance($lwsMap["registrationId"], $lwsMap["max_instance"]);
            $regRptElement = $rspXml->addChild("registrationreport");

            $this->BuildRegListResultReport($regRptElement,
                $lwsMap,
                $resultsFormat,
                $activityResult,
                $lwsMap["learnerId"],
                $lwsMap["learnerFirstName"] . ' ' . $lwsMap["learnerLastName"]);
        }
        $xmlString = APIMappings::GetXmlString($rspXml);

        return $xmlString;
    }

    /// <summary>
    /// Returns a list of registration id's along with their associated course
    /// </summary>
    /// <param name="courseId>Option course id filter</param>
    /// <param name="learnerId>Option learner id filter</param>
    public function GetRegistrationList($courseId, $learnerId)
    {
        //if($learnerId === "" or is_null($learnerId))
        //    return array();

        $rspXml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><rsp stat="ok"></rsp>');
        $listXml = $rspXml->addChild("registrationlist");

        //map to hold registrations above the "instances" (or other words non-instances.
        $lwsRegistrationMap = $this->getRegistrationApiResults($courseId, $learnerId);
        ksort($lwsRegistrationMap);
        foreach($lwsRegistrationMap as $lwsMap)
        {
            //build the Registration Detail section.
            $this->BuildRegistrationDetail($listXml, $lwsMap);
        }
        $regData = new RegistrationData(null);
        //var_dump($rspXml);
        $regArray = $regData->ConvertToRegistrationDataList($rspXml->asXML());
        return $regArray;
    }

    /// <summary>
    /// Returns the detail of a registration
    /// </summary>
    /// <param name="$registrationId">the registration id for the requested detail</param>
    public function GetRegistrationDetail($registrationId)
    {
        $rspXml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><rsp stat="ok"></rsp>');
        $lwsRegMap = $this->getRegistrationApiResultByRegistrationId($registrationId);
        //var_dump($lwsRegMap);
        $this->BuildRegistrationDetail($rspXml , $lwsRegMap[$registrationId]);
        $xmlString = APIMappings::GetXmlString($rspXml);
        return $rspXml->asXML();
    }

    /// <summary>
    /// Returns a list of registration id's along with their associated course
    /// </summary>
    /// <param name="courseId">Option course id filter</param>
    /// <param name="learnerId">Optional learner id filter</param>
    /// <param name="resultsFormat">@deprecated only format supported is xml.</param>
    public function GetRegistrationListResults($courseId, $learnerId, $resultsFormat)
    {
        if($learnerId === "" or is_null($learnerId))
            return '<?xml version="1.0" encoding="utf-8" ?>' . "\n" .'<rsp stat="ok"><registrationlist></registrationlist></rsp>';


        $rspXml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><rsp stat="ok"></rsp>');
        $listXml = $rspXml->addChild("registrationlist");

        //map to hold registrations above the "instances" (or other words non-instances.
        $lwsRegistrationMap = $this->getRegistrationApiResults($courseId, $learnerId);

        ksort($lwsRegistrationMap);
        foreach($lwsRegistrationMap as $lwsMap)
        {

            //build the Registration Detail section.
            $regTag = $this->BuildRegistrationDetail($listXml, $lwsMap);


            //next we must get the activity detail for this last registration instance.
            $activityResult = $this->registrationApiClient->getRegistrationProgressDetailByRegistrationIdByInstance($lwsMap["registrationId"], $lwsMap["max_instance"]);
            $regRptElement = $regTag->addChild("registrationreport");

            $this->BuildRegListResultReport($regRptElement,
                                            $lwsMap,
                                            $resultsFormat,
                                            $activityResult,
                                            $lwsMap["learnerId"],
                                            $lwsMap["learnerFirstName"] . ' ' . $lwsMap["learnerLastName"]);
        }
        return $rspXml->asXML();
    }

    /// <summary>
    /// Return a registration summary object for the given registration
    /// </summary>
    /// <param name="registrationId">The unique identifier of the registration</param>
    public function GetRegistrationSummary($registrationId)
    {
        $result = $this->registrationApiClient->getRegistrationProgressDetailByRegistrationId($registrationId);
        $summaryXml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><rsp stat="ok"></rsp>');

        $regReportChild = $summaryXml->addChild('registrationreport');
        $regReportChild->addAttribute("format","course");
        $regReportChild->addAttribute("regid",$result->id);
        $regReportChild->addAttribute("instanceid",$result->instance);

        $regReportChild->addChild("complete",strtolower($result->registrationCompletion));
        $regReportChild->addChild("success",strtolower($result->registrationSuccess));
        $regReportChild->addChild("totaltime",$result->totalSecondsTracked);
        $regReportChild->addChild("score",$result->score ?: "unknown");

        $returnVal = new RegistrationSummary($regReportChild);
        //var_dump($returnVal);
        return $returnVal;
    }

    /// <summary>
    /// Return a true if registration exists else false.
    /// </summary>
    /// <param name="registrationId">The unique identifier of the registration</param>
    public function Exists($registrationId)
    {
        $exists = false;
        try {
            $result = $this->registrationApiClient->getRegistrationByRegistrationId($registrationId);
            $exists = $result->exists;
        }
        catch(\Exception $ex)
        {
            $exists = false;
        }
        return $exists;
    }

    /// <summary>
    /// Resets all status data regarding the specified registration -- essentially restarts the course
    /// </summary>
    /// <param name="registrationId">Unique Identifier for the registration</param>
    public function ResetRegistration($registrationId)
    {
        $this->registrationApiClient->deleteRegistrationProgressByRegistrationId($registrationId);
    }

    /// <summary>
    /// Clears global objective data for the given registration
    /// </summary>
    /// <param name="registrationId">Unique Identifier for the registration</param>
    /// <param name="deleteLatestInstanceOnly">If false, all instances are deleted</param>
    public function ResetGlobalObjectives($registrationId, $deleteLatestInstanceOnly = true)
    {
        if($deleteLatestInstanceOnly === true || $deleteLatestInstanceOnly === 'true')
        {
            throw new \Exception("Current API does not support Resetting Global data of a specific instance");
        }
        
        $this->registrationApiClient->deleteRegistrationGlobalDataByRegistrationId($registrationId);
    }

    /// <summary>
    /// Gets the url to directly launch/view the course registration in a browser
    /// </summary>
    /// <param name="registrationId">Unique Identifier for the registration</param>
    /// <param name="redirectOnExitUrl">Upon exit, the url that the SCORM player will redirect to</param>
    /// <param name="cssUrl">@deprecated no longer used. Absolute url that points to a custom player style sheet</param>
    /// <param name="debugLogPointerUrl">@deprecated no longer used.</param>
    /// <param name="courseTags">@deprecated no longer used.</param>
    /// <param name="learnerTags">@deprecated no longer used.</param>
    /// <param name="registrationTags">@deprecated no longer used.</param>
    /// <returns>URL to launch</returns>
    public function GetLaunchUrl($registrationId, $redirectOnExitUrl = null, $cssUrl = null, $debugLogPointerUrl = null, $courseTags = null, $learnerTags = null, $registrationTags = null)
    {
        $result = $this->registrationApiClient->getRegistrationLaunchLinkByRegistrationIdByExpiryByForceReviewByStartScoByRedirectOnExitUrl($registrationId,0,false,"",$redirectOnExitUrl);
        $engineUrl = $this->GetEngineServerUrl();
        return "$engineUrl$result->launchLink";
    }

    /// <summary>
    /// Delete the specified instance of the registration
    /// </summary>
    /// <param name="registrationId">Unique Identifier for the registration</param>
    /// <param name="instanceId">Specific instance of the registration to delete</param>
    public function DeleteRegistration($registrationId, $deleteLatestInstanceOnly = False)
    {
        //we will need on the registration side, a way to get the latest instance.
        if($deleteLatestInstanceOnly === true || $deleteLatestInstanceOnly === 'true')
        {
            throw new \Exception("Current API does not support Deleting of a specific instance");
        }
        $this->registrationApiClient->deleteRegistrationByRegistrationId($registrationId);
    }

    /******* Functions not supported ********/
    public function DeleteRegistrationInstance($registrationId, $instanceId)
    {
        throw new \Exception("Current API does not support DeleteRegistrationInstance of a specific instance");
    }
    public function UpdateLearnerInfo($learnerid, $fname, $lname, $newid = null)
    {
        throw new \Exception("Current API does not support UpdateLearnerInfo()");
    }
    public function GetLaunchHistory($registrationId)
    {
        throw new \Exception("Current API does not support GetLaunchHistory()");
    }
    public function GetLaunchInfo($launchId)
    {
        throw new \Exception("Current API does not support GetLaunchInfo()");
    }
    public function GetRegistrationResultUrl($registrationId, $resultsFormat, $dataFormat)
    {
        throw new \Exception("Current API does not support GetRegistrationResultUrl()");
    }
    /******* End of Functions not supported ********/

    private function BuildCourseReport($parentElement, $activityDetail, $totalTime)
    {
        $parentElement->addChild("complete", APIMappings::MapActivityCompletionToLws($activityDetail->activityCompletion));
        $parentElement->addChild("success", APIMappings::MapActivitySuccessToLws($activityDetail->activitySuccess));
        $parentElement->addChild("totaltime", (string)$totalTime);
        $score = is_null($activityDetail->score) ? "unknown" : (string)$activityDetail->score->scaled;
        $parentElement->addChild("score", $score);
    }

    private function BuildActivityReport($parentElement, $activityDetail)
    {
        $activityElement = $parentElement->addChild("activity");
        $activityElement->addAttribute("id", (string)$activityDetail->id);
        $activityElement->addChild("title", $activityDetail->title);
        $activityElement->addChild("attempts", (string)$activityDetail->attempts);
        $activityElement->addChild("complete", APIMappings::MapActivityCompletionToLws($activityDetail->activityCompletion));
        $activityElement->addChild("success", APIMappings::MapActivitySuccessToLws($activityDetail->activitySuccess));
        $activityElement->addChild("time", (string)$activityDetail->timeTracked);
        $score = is_null($activityDetail->score) ? "unknown" : (string)$activityDetail->score->scaled;
        $activityElement->addChild("score", $score);

        //use recursion to generate the same for each child.
        $childrenElement = $activityElement->addChild("children");
        if(!empty($activityDetail->children))
        {
            foreach($activityDetail->children as $activityDetailChild)
            {
                //use recursion for each child.
                $this->BuildActivityReport($childrenElement, $activityDetailChild);
            }
        }
    }

    private function BuildFullReport($parentElement, $activityDetail, $learnerId, $learnerName)
    {
        $activityElement = $this->BuildActivityElement($parentElement, $activityDetail);

        //build the activity objectives.
        $this->BuildActivityObjectives($activityDetail, $activityElement);

        //build the runtime section.
        $this->BuildFullRuntime($activityDetail, $learnerId, $learnerName, $activityElement);

        //use recursion to generate the same for each child.
        $childrenElement = $activityElement->addChild("children");
        if(!empty($activityDetail->children))
        {
            foreach($activityDetail->children as $activityDetailChild)
            {
                //use recursion for each child.
                $this->BuildFullReport($childrenElement, $activityDetailChild, $learnerId ,$learnerName);
            }
        }
    }

    private function BuildRegListResultReport($regRptElement,
                                              $lwsMap,
                                              $resultsFormat,
                                              $activityResult,
                                              $learnerId,
                                              $learnerName)
    {
        if (is_null($activityResult->activityDetails))
            return;

        $activityDetail = $activityResult->activityDetails;
        if((int)$resultsFormat === 0) //course
        {
            //var_dump($activityResult);
            $regRptElement->addAttribute("format", "course");
            $this->BuildCourseReport($regRptElement, $activityDetail, $lwsMap["max_totaltime"]);
        }
        elseif((int)$resultsFormat === 1) //activity.
        {
            //var_dump($activityResult);
            $regRptElement->addAttribute("format", "activity");

            //use a recursive function to build the children.
            $this->BuildActivityReport($regRptElement, $activityDetail);
        }
        elseif((int)$resultsFormat === 2) //full
        {
            $regRptElement->addAttribute("format", "full");
            $this->BuildFullReport($regRptElement, $activityDetail, $learnerId, $learnerName);
        }

        $regRptElement->addAttribute("regid", $lwsMap["registrationId"]);
        $regRptElement->addAttribute("instanceid", $lwsMap["max_instance"]);

    }

    private function ExtractMore($listSchemaWithMore)
    {
        $parts = parse_url($listSchemaWithMore->more);
        $more = null;
        if (array_key_exists("query", $parts)) {
            parse_str($parts['query'], $query);
            $more = $query['more'];
            return $more;
        }
        return $more;
    }

    //unfortunately until we can get registrations back by registrationId
    //we have to get the last instance on and get progress working backwards
    //on the instances.
    private function getRegistrationApiResultByRegistrationId($registrationId)
    {
        $lwsRegistrationMap = array();
        //first get the last instance back.
        $lastInstanceResult = $this->registrationApiClient->getRegistrationLastInstanceByRegistrationId($registrationId);

        //go thru the instances and get the needed information
        $firstTime = true;
        for($i=$lastInstanceResult->result; $i>=0; $i--)
        {

            $registration = $this->registrationApiClient->getRegistrationProgressByRegistrationIdByInstance($registrationId, $i);

            if(is_null($registration))
                continue;

            if($firstTime)
            {
                $lwsRegistrationMap[$registration->id] = array();
                $lwsRegistrationMap[$registration->id]["courseId"] = $registration->course->id;
                $lwsRegistrationMap[$registration->id]["appId"] = $this->configuration->getTenant();
                $lwsRegistrationMap[$registration->id]["registrationId"] = $registration->id;
                $lwsRegistrationMap[$registration->id]["courseId"] = $registration->course->id;
                $lwsRegistrationMap[$registration->id]["courseTitle"] = $registration->course->title;

                //$courseTitleResult = $this->courseApiClient->getCourseTitleByCourseId($registration->courseId);
                //TODO: Implement, would need to extend the new API to add this.
                $lwsRegistrationMap[$registration->id]["lastCourseVersionLaunched"] = -1;
                $lwsRegistrationMap[$registration->id]["learnerId"] = $registration->learner->id;
                $lwsRegistrationMap[$registration->id]["learnerFirstName"] = $registration->learner->firstName;
                $lwsRegistrationMap[$registration->id]["learnerLastName"] = $registration->learner->lastName;
                //TODO: implement, would need to extend the new API to add this.
                $lwsRegistrationMap[$registration->id]["email"] = "";


                //TODO: implement, would need to extend the new API to add this.
                $lwsRegistrationMap[$registration->id]["createDate"] = self::DEFAULT_DATE;
                //TODO: implement, would need to extend the new API to add this.
                $lwsRegistrationMap[$registration->id]["firstAccessDate"] = self::DEFAULT_DATE;
                //TODO: implement, would need to extend the new API to add this.
                $lwsRegistrationMap[$registration->id]["lastAccessDate"] = self::DEFAULT_DATE;
                //TODO: implement, would need to extend the new API to add this.
                $lwsRegistrationMap[$registration->id]["lastAccessDate"] = self::DEFAULT_DATE;
                //TODO: implement, would need to extend the new API to add this.
                $lwsRegistrationMap[$registration->id]["completedDate"] = self::DEFAULT_DATE;
                $lwsRegistrationMap[$registration->id]["instances"] = array();
                $lwsRegistrationMap[$registration->id]["max_instance"] = $registration->instance;
                $lwsRegistrationMap[$registration->id]["max_totaltime"] = $registration->totalSecondsTracked;
                //$lwsRegistrationMap[$registration->id]["activity"] = $registration->activityDetails;
                $firstTime = false;
            }

            $instanceItem = array();
            $instanceItem["instanceId"] = $registration->instance;
            $instanceItem["courseVersion"] = $registration->course->version;
            $instanceItem["updateDate"] = $registration->updated;

            array_push($lwsRegistrationMap[$registration->id]["instances"], $instanceItem);

            if($lwsRegistrationMap[$registration->id]["max_instance"] < $registration->instance)
            {
                $lwsRegistrationMap[$registration->id]["max_instance"] = $registration->instance;
                $lwsRegistrationMap[$registration->id]["max_totaltime"] = $registration->totalSecondsTracked;
            }

        }
        return $lwsRegistrationMap;
    }

    private function getRegistrationApiResults($courseId, $learnerId)
    {
        $results = $this->registrationApiClient->getRegistrationsByCourseIdByLearnerIdBySinceByMore($courseId, $learnerId, self::DEFAULT_DATE, null);
        $lwsRegistrationMap = array();
        $count = 0;
        do
        {
            $more = $this->ExtractMore($results);
            //var_dump($more);
            foreach($results->registrations as $registration)
            {

                if(!array_key_exists($registration->id,$lwsRegistrationMap))
                {
                    $lwsRegistrationMap[$registration->id] = array();
                    $lwsRegistrationMap[$registration->id]["courseId"] = $registration->course->id;
                    $lwsRegistrationMap[$registration->id]["appId"] = $this->configuration->getTenant();
                    $lwsRegistrationMap[$registration->id]["registrationId"] = $registration->id;
                    $lwsRegistrationMap[$registration->id]["courseId"] = $registration->course->id;
                    $lwsRegistrationMap[$registration->id]["courseTitle"] = $registration->course->title;

                    //$courseTitleResult = $this->courseApiClient->getCourseTitleByCourseId($registration->courseId);
                    //TODO: Implement, would need to extend the new API to add this.
                    $lwsRegistrationMap[$registration->id]["lastCourseVersionLaunched"] = -1;
                    $lwsRegistrationMap[$registration->id]["learnerId"] = $registration->learner->id;
                    $lwsRegistrationMap[$registration->id]["learnerFirstName"] = $registration->learner->firstName;
                    $lwsRegistrationMap[$registration->id]["learnerLastName"] = $registration->learner->lastName;
                    //TODO: implement, would need to extend the new API to add this.
                    $lwsRegistrationMap[$registration->id]["email"] = "";


                    //TODO: implement, would need to extend the new API to add this.
                    $lwsRegistrationMap[$registration->id]["createDate"] = self::DEFAULT_DATE;
                    //TODO: implement, would need to extend the new API to add this.
                    $lwsRegistrationMap[$registration->id]["firstAccessDate"] = self::DEFAULT_DATE;
                    //TODO: implement, would need to extend the new API to add this.
                    $lwsRegistrationMap[$registration->id]["lastAccessDate"] = self::DEFAULT_DATE;
                    //TODO: implement, would need to extend the new API to add this.
                    $lwsRegistrationMap[$registration->id]["lastAccessDate"] = self::DEFAULT_DATE;
                    //TODO: implement, would need to extend the new API to add this.
                    $lwsRegistrationMap[$registration->id]["completedDate"] = self::DEFAULT_DATE;
                    $lwsRegistrationMap[$registration->id]["instances"] = array();
                    $lwsRegistrationMap[$registration->id]["max_instance"] = $registration->instance;
                    $lwsRegistrationMap[$registration->id]["max_totaltime"] = $registration->totalSecondsTracked;
                    //$lwsRegistrationMap[$registration->id]["activity"] = $registration->activityDetails;
                }

                $instanceItem = array();
                $instanceItem["instanceId"] = $registration->instance;
                $instanceItem["courseVersion"] = $registration->course->version;
                $instanceItem["updateDate"] = $registration->updated;

                array_push($lwsRegistrationMap[$registration->id]["instances"], $instanceItem);

                if($lwsRegistrationMap[$registration->id]["max_instance"] < $registration->instance)
                {
                    $lwsRegistrationMap[$registration->id]["max_instance"] = $registration->instance;
                    $lwsRegistrationMap[$registration->id]["max_totaltime"] = $registration->totalSecondsTracked;
                }
            }

            if(!is_null($more)){
                $results = $this->registrationApiClient->getRegistrationsByCourseIdByLearnerIdBySinceByMore($courseId, $learnerId, self::DEFAULT_DATE, $more);
            }
            $count++;
        }while(!is_null($more) && $count < self::MAX_REG_API_CALL);
        //arsort($lwsRegistrationMap[$registration->id]["instances"]);
        //var_dump($lwsRegistrationMap[$registration->id]["instances"]);

        return $lwsRegistrationMap;
    }

    /**
     * @param $runtimeElement
     * @param $runtime
     */
    private function BuildRuntimeObjectives($runtimeElement, $runtime)
    {
        $runtimeObjectivesElement = $runtimeElement->addChild("objectives");
        foreach ($runtime->runtimeObjectives as $runtimeObjective) {
            $runtimeObjectiveElement = $runtimeObjectivesElement->addChild("objective");
            $runtimeObjectiveElement->addAttribute("score_scaled", $runtimeObjective->scoreScaled);
            $runtimeObjectiveElement->addChild("score_min", $runtimeObjective->scoreMin);
            $runtimeObjectiveElement->addChild("score_raw", $runtimeObjective->scoreRaw);
            $runtimeObjectiveElement->addChild("score_max", $runtimeObjective->scoreMax);
            $runtimeObjectiveElement->addChild("success_status", APIMappings::getApiRuntimeSuccessStatusToLws($runtimeObjective->successStatus));
            $runtimeObjectiveElement->addChild("completion_status", APIMappings::getApiRuntimeCompletionStatus($runtimeObjective->completionStatus));
            $runtimeObjectiveElement->addChild("progress_measure", $runtimeObjective->progressMeasure);
            $runtimeObjectiveElement->addChild("description", $runtimeObjective->description);
        }
    }

    /**
     * @param $activityDetail
     * @param $learnerId
     * @param $learnerName
     * @param $runtimeElement
     */
    private function BuildRuntimeStaticProps($activityDetail, $learnerId, $learnerName, $runtimeElement)
    {
        $staticProperties = $activityDetail->staticProperties;
        $staticElement = $runtimeElement->addChild("static");
        $staticElement->addChild("completion_threshold", $staticProperties->completionThreshold);
        $staticElement->addChild("launch_data", $staticProperties->launchData);
        $staticElement->addChild("learner_id", $learnerId);
        $staticElement->addChild("learner_name", $learnerName);
        $staticElement->addChild("max_time_allowed", $staticProperties->maxTimeAllowed);
        //if ($staticProperties->scaledPassingScoreUsed) {
            $staticElement->addChild("scaled_passing_score", ($staticProperties->scaledPassingScore == -1.0 ? "" : number_format($staticProperties->scaledPassingScore,1)));
        //}
        $staticElement->addChild("time_limit_action", $staticProperties->timeLimitAction === "" ? "Undefined" : $staticProperties->timeLimitAction);
    }

    /**
     * @param $runtimeElement
     * @param $runtime
     */
    private function BuildRuntimeInteractions($runtimeElement, $runtime)
    {
        $interactionsElement = $runtimeElement->addChild("interactions");
        foreach ($runtime->runtimeInteractions as $runtimeInteraction) {
            $interactionElement = $interactionsElement->addChild("interaction");
            $interactionElement . addAttribute("id", $runtimeInteraction->id);
            $interactionElement . addChild("type", $runtimeInteraction->type);

            $runtimeIntObjsElement = $interactionElement . addChild("objectives");
            foreach ($runtimeInteraction->objectives as $objectiveId) {
                $runtimeIntObjElement = $runtimeIntObjsElement->addChild("objective");
                $runtimeIntObjElement . addAttribute("id", $objectiveId);
            }

            $interactionElement . addChild("timestamp", $runtimeInteraction->timestamp);

            $correctResponsesElement = $interactionElement . addChild("correct_responses");
            foreach ($runtimeInteraction->correctResponses as $correctResponseId) {
                $correctResponseElement = $correctResponsesElement->addChild("response");
                $correctResponseElement->addAttribute("id", $correctResponseId);
            }

            $interactionElement->addChild("weighting", $runtimeInteraction->weighting);
            $interactionElement->addChild("learner_response", $runtimeInteraction->learnerResponse);
            $interactionElement->addChild("result", $runtimeInteraction->result);
            $interactionElement->addChild("latency", $runtimeInteraction->latency);
            $interactionElement->addChild("description", $runtimeInteraction->description);
        }
    }

    /**
     * @param $runtimeElement
     * @param $runtime
     */
    private function BuildRuntimeLmsComments($runtimeElement, $runtime)
    {
        $commentLmsElement = $runtimeElement->addChild("comments_from_lms");
        foreach ($runtime->lmsComments as $lmsComment) {
            $commentLmsElement->addChild("value", $lmsComment->value);
            $commentLmsElement->addChild("location", $lmsComment->location);
            $commentLmsElement->addChild("date_time", $lmsComment->dateTime);
        }
    }

    /**
     * @param $runtimeElement
     * @param $runtime
     */
    private function BuildRuntimeLearnerComments($runtimeElement, $runtime)
    {
        $commentLrnElement = $runtimeElement->addChild("comments_from_learner");
        foreach ($runtime->learnerComments as $lrnComment) {
            $commentLrnElement->addChild("value", $lrnComment->value);
            $commentLrnElement->addChild("location", $lrnComment->location);
            $commentLrnElement->addChild("date_time", $lrnComment->dateTime);
        }
    }

    /**
     * @param $runtime
     * @param $runtimeElement
     */
    private function BuildRuntimeLearnerPreference($runtime, $runtimeElement)
    {
        if (!is_null($runtime->learnerPreference)) {
            $learnerPref = $runtime->learnerPreference;
            $learnerPerfElement = $runtimeElement->addChild("learnerpreference");
            $learnerPerfElement->addChild("audio_level", number_format($learnerPref->audioLevel, 1));
            $learnerPerfElement->addChild("language", $learnerPref->language);
            $learnerPerfElement->addChild("delivery_speed", number_format($learnerPref->deliverySpeed, 1));
            $learnerPerfElement->addChild("audio_captioning", $learnerPref->audioCaptioning);
        }
    }

    /**
     * @param $runtimeElement
     * @param $runtime
     */
    private function BuildRuntimeCreditEntryExit($runtimeElement, $runtime)
    {
        $runtimeElement->addChild("credit", APIMappings::getApiRuntimeCreditToLws($runtime->credit));
        $runtimeElement->addChild("entry", APIMappings::getApiRuntimeEntryToLws($runtime->entry));
        $runtimeElement->addChild("exit", APIMappings::getApiRuntimeExitToLws($runtime->exit));
    }

    /**
     * @param $runtimeElement
     * @param $runtime
     */
    private function BuildRuntimeTopLevelElements($runtimeElement, $runtime)
    {
        $runtimeElement->addChild("location", is_null($runtime->location) ? 'null' : $runtime->location);
        $runtimeElement->addChild("mode", APIMappings::getApiRuntimeModeToLws($runtime->mode));
        $runtimeElement->addChild("progress_measure", $runtime->progressMeasure);
        $runtimeElement->addChild("score_scaled", $runtime->scoreScaled);
        $runtimeElement->addChild("score_raw", $runtime->scoreRaw);
        $runtimeElement->addChild("score_min", $runtime->scoreMin);
        $runtimeElement->addChild("score_max", $runtime->scoreMax);
        $runtimeElement->addChild("total_time", $runtime->totalTime);
        $runtimeElement->addChild("timetracked", $runtime->timeTracked);
        $runtimeElement->addChild("success_status", APIMappings::getApiRuntimeSuccessStatusToLws($runtime->successStatus));
        APIMappings::addCData("suspend_data", $runtime->suspendData, $runtimeElement);
    }

    /**
     * @param $activityDetail
     * @param $learnerId
     * @param $learnerName
     * @param $activityElement
     */
    private function BuildFullRuntime($activityDetail, $learnerId, $learnerName, $activityElement)
    {
        if (!is_null($activityDetail->runtime)) {
            //$runtime = new model\runtimeSchema();//$activityDetail->runtime;
            $runtime = $activityDetail->runtime;
            $runtimeElement = $activityElement->addChild("runtime");

            $runtimeElement->addChild("completion_status", APIMappings::getApiRuntimeCompletionStatus($runtime->completionStatus));
            //build the credit, entry and exit for the runtime.
            $this->BuildRuntimeCreditEntryExit($runtimeElement, $runtime);

            //build runtime learner preference.
            $this->BuildRuntimeLearnerPreference($runtime, $runtimeElement);

            //build the top level elements for the runtime xml doc.
            $this->BuildRuntimeTopLevelElements($runtimeElement, $runtime);

            //build runtime learner and lms comments.
            $this->BuildRuntimeLearnerComments($runtimeElement, $runtime);
            $this->BuildRuntimeLmsComments($runtimeElement, $runtime);

            //runtime interactions
            $this->BuildRuntimeInteractions($runtimeElement, $runtime);

            //runtime objectives
            $this->BuildRuntimeObjectives($runtimeElement, $runtime);

            //runtime static properties
            $this->BuildRuntimeStaticProps($activityDetail, $learnerId, $learnerName, $runtimeElement);
        }
    }

    /**
     * @param $activityDetail
     * @param $activityElement
     */
    private function BuildActivityObjectives($activityDetail, $activityElement)
    {
        $objectivesElement = $activityElement->addChild("objectives");
        foreach ($activityDetail->objectives as $objective) {
            $objectiveElement = $objectivesElement->addChild("objective");
            $objectiveElement->addAttribute("id", $objective->id);
            $objectiveElement->addAttribute("primary", $objective->primary ? "true" : "false");
            $objectiveElement->addChild("measurestatus", !is_null($objective->score) ? 'true' : 'false');
            $objectiveElement->addChild("normalizedmeasure", is_null($objective->score) ? "0.0" : number_format($objective->score->scaled / 100, 1));
            $objectiveElement->addChild("progressstatus", $objective->objectiveSuccess != model\objectiveSuccess::UNKNOWN ? 'true' : 'false');
            $objectiveElement->addChild("satisfiedstatus", $objective->objectiveSuccess != model\objectiveSuccess::UNKNOWN ? 'true' : 'false');
        }
    }

    /**
     * @param $parentElement
     * @param $activityDetail
     * @return mixed
     */
    private function BuildActivityElement($parentElement, $activityDetail)
    {
        $activityElement = $parentElement->addChild("activity");
        $activityElement->addAttribute("id", (string)$activityDetail->id);
        $activityElement->addChild("title", $activityDetail->title);
        $activityElement->addChild("satisfied", $activityDetail->activitySuccess != model\activitySuccess::UNKNOWN ? 'true' : 'false');
        $activityElement->addChild("completed", $activityDetail->activityCompletion == model\activityCompletion::COMPLETED ? 'true' : 'false');
        $activityElement->addChild("progressstatus", $activityDetail->activitySuccess != model\activitySuccess::UNKNOWN ? 'true' : 'false');
        $activityElement->addChild("attemptprogressstatus", $activityDetail->activityCompletion != model\activityCompletion::UNKNOWN ? 'true' : 'false');
        $activityElement->addChild("attempts", (string)$activityDetail->attempts);
        $activityElement->addChild("suspended", (string)$activityDetail->suspended ? 'true' : 'false');
        return $activityElement;
    }

    /**
     * @param $listXml
     * @param $lwsMap
     * @return mixed
     */
    private function BuildRegistrationDetail($listXml, $lwsMap)
    {
        $regTag = $listXml->addChild("registration");
        $regTag->addAttribute("id", $lwsMap["registrationId"]);
        $regTag->addAttribute("courseid", $lwsMap["courseId"]);
        APIMappings::addCData("appId", $this->configuration->getTenant(), $regTag);
        APIMappings::addCData("registrationId", $lwsMap["registrationId"], $regTag);
        APIMappings::addCData("courseId", $lwsMap["courseId"], $regTag);
        APIMappings::addCData("courseTitle", $lwsMap["courseTitle"], $regTag);

        APIMappings::addCData("lastCourseVersionLaunched", $lwsMap["lastCourseVersionLaunched"], $regTag);
        APIMappings::addCData("learnerId", $lwsMap["learnerId"], $regTag);
        APIMappings::addCData("learnerFirstName", $lwsMap["learnerFirstName"], $regTag);
        APIMappings::addCData("learnerLastName", $lwsMap["learnerLastName"], $regTag);
        $regTag->addChild("email");

        APIMappings::addCData("createDate", $lwsMap["createDate"], $regTag);
        APIMappings::addCData("firstAccessDate", $lwsMap["firstAccessDate"], $regTag);
        APIMappings::addCData("lastAccessDate", $lwsMap["lastAccessDate"], $regTag);
        APIMappings::addCData("completedDate", $lwsMap["completedDate"], $regTag);
        $instancesElement = $regTag->addChild("instances");
        foreach ($lwsMap["instances"] as $instance) {
            $instanceElement = $instancesElement->addChild("instance");
            APIMappings::addCData("instanceId", $instance["instanceId"], $instanceElement);
            APIMappings::addCData("courseVersion", $instance["courseVersion"], $instanceElement);
            APIMappings::addCData("updateDate", $instance["updateDate"], $instanceElement);
        }
        return $regTag;
    }

    private function GetEngineServerUrl(){
        $parsed_url = parse_url($this->configuration->getScormEngineServiceUrl());
        $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
        $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
        return "$scheme$host$port";
    }


}
