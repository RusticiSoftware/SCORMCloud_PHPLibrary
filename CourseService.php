<?php

/* Software License Agreement (BSD License)
 * 
 * Copyright (c) 2010-2011, Rustici Software, LLC
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the <organization> nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL Rustici Software, LLC BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

require_once 'ServiceRequest.php';
require_once 'CourseData.php';
require_once 'Enums.php';
require_once 'UploadService.php';
require_once 'ImportResult.php';
require_once 'DebugLogger.php';

/// <summary>
/// Client-side proxy for the "rustici.course.*" Hosted SCORM Engine web
/// service methods.  
/// </summary>
class CourseService{
	
	private $_configuration = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
		//echo $this->_configuration->getAppId();
	}
	
	/// <summary>
    /// Import a SCORM .pif (zip file) from the local filesystem.
    /// </summary>
    /// <param name="courseId">Unique Identifier for this course.</param>
    /// <param name="absoluteFilePathToZip">Full path to the .zip file</param>
    /// <param name="itemIdToImport">ID of manifest item to import. If null, root organization is imported</param>
    /// <param name="permissionDomain">An permission domain to associate this course with, 
    /// for ftp access service (see ftp service below). 
    /// If the domain specified does not exist, the course will be placed in the default permission domain</param>
    /// <returns>List of Import Results</returns>
    public function ImportCourse($courseId, $absoluteFilePathToZip, $itemIdToImport = null)
    {
    	$uploadService = new UploadService($this->_configuration);
    	$location = $uploadService->UploadFile($absoluteFilePathToZip);
    	
    	$importException = null;
    	$response = null;
    	try {
    		$response = $this->ImportUploadedCourse($courseId, $location);
    	} catch (Exception $ex) {
    		$importException = $ex;
    	}
    	
    	$uploadService->DeleteFile($location);
    	
    	if($importException != null){
    		throw $importException;
    	}
    	
    	return $response;
    }
    
    ///function VersionCourse has been deprecated from the course service 
    
    /// <summary>
     /// Import a SCORM .pif (zip file) from an existing .zip file on the
     /// Hosted SCORM Engine server.
     /// </summary>
     /// <param name="courseId">Unique Identifier for this course.</param>
     /// <param name="path">The relative path (rooted at your specific appid's upload area)
     /// where the zip file for importing can be found</param>
     /// <param name="fileName">Name of the file, including extension.</param>
     /// <param name="itemIdToImport">ID of manifest item to import</param>
     /// <param name="permissionDomain">An permission domain to associate this course with, 
     /// for ftp access service (see ftp service below). 
     /// If the domain specified does not exist, the course will be placed in the default permission domain</param>
     /// <returns>List of Import Results</returns>
     public function ImportUploadedCourse($courseId, $path, $permissionDomain = null)
     {

        $request = new ServiceRequest($this->_configuration);
		$params = array('courseid'=>$courseId,
						'path'=>$path);

       // if (!is_null($itemIdToImport))
		//{
//			$params[] = 'itemid' => $itemIdToImport;
		//}
        
         //if (!String.IsNullOrEmpty(permissionDomain))
         //    request.Parameters.Add("pd", permissionDomain);
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.course.importCourse");

		write_log('rustici.course.importCourse : '.$response);
		
		$importResult = new ImportResult(null);
		return $importResult->ConvertToImportResults($response);
     }

     ///function VersionCourse has been deprecated from the course service 

     /// <summary>
     /// Check the existence of a course with the given courseId
     /// configured appId.
     /// </summary>
  	/// <param name="courseId">courseId of the course to check for</param>
     /// <returns>boolean value</returns>
    public function Exists($courseId) {
        $request = new ServiceRequest($this->_configuration);
        $params = array('courseid'=>$courseId);
        $request->setMethodParams($params);
        $response = $request->CallService("rustici.course.exists");
        $xml = simplexml_load_string($response);
        write_log($xml->result);
        return ($xml->result == 'true');
    }

    /// <summary>
    /// Retrieve a list of high-level data about all courses owned by the 
    /// configured appId.
    /// </summary>
 	/// <param name="courseIdFilterRegex">Regular expresion to filter the courses by ID</param>
    /// <returns>List of Course Data objects</returns>
    public function GetCourseList($courseIdFilterRegex = null)
    {
        $request = new ServiceRequest($this->_configuration);

		if(isset($courseIdFilterRegex))
		{
			$params = array('filter'=>$courseIdFilterRegex);
			$request->setMethodParams($params);
		}

        $response = $request->CallService("rustici.course.getCourseList");
		$CourseDataObject = new CourseData(null);
        return $CourseDataObject->ConvertToCourseDataList($response);
    }
   /// <summary>
    /// Delete the specified course
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="deleteLatestVersionOnly">If false, all versions are deleted</param>
    public function DeleteCourse($courseId, $deleteLatestVersionOnly = False)
    {
        $request = new ServiceRequest($this->_configuration);
       	$params = array('courseid'=>$courseId);
        if (isset($deleteLatestVersionOnly) && $deleteLatestVersionOnly)
		{ 
            $params['versionid'] = 'latest';
		}
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.course.deleteCourse");
		return $response;
    }
    
    /// <summary>
    /// Delete the specified version of a course
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="versionId">Specific version of course to delete</param>
    public function DeleteCourseVersion($courseId, $versionId)
    {
        $request = new ServiceRequest($this->_configuration);
		$params = array('courseid' => $courseId,
						'versionid' => $versionId);
       	$request->setMethodParams($params);
        $response = $request->CallService("rustici.course.deleteCourse");
		return $response;
    }
    
    /// <summary>
    /// Get the Course Details in XML Format
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    public function GetCourseDetail($courseId)
    {
        $request = new ServiceRequest($this->_configuration);
       	$params = array('courseid'=>$courseId);
       	$request->setMethodParams($params);
        return $request->CallService("rustici.course.getCourseDetail");
    }
    
	/// <summary>
    /// Get the Course Metadata in XML Format
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="versionId">Version of the specified course</param>
    /// <param name="scope">Defines the scope of the data to return: Course or Activity level</param>
    /// <param name="format">Defines the amount of data to return:  Summary or Detailed</param>
    /// <returns>XML string representing the Metadata</returns>
    public function GetMetadata($courseId, $versionId, $scope, $format)
    {
		$enum = new Enum();
        $request = new ServiceRequest($this->_configuration);
		$params = array('courseid'=>$courseId);
        
        if (isset($versionId) && $versionId != 0)
        {
            $params['versionid'] = $versionId;
        }
        $params['scope'] = $enum->getMetadataScope($scope);
        $params['mdformat'] = $enum->getDataFormat($format);
		
		$request->setMethodParams($params);
		
        $response = $request->CallService("rustici.course.getMetadata");
        
        // Return the subset of the xml starting with the top <object>
        return $response;
    }

    /// <summary>
    /// Get the url that can be opened in a browser and used to preview this course, without
    /// the need for a registration.
    /// </summary>
    /// <param name="courseId">Unique Course Identifier</param>
    /// <param name="versionId">Version Id</param>
    public function GetPreviewUrl($courseId, $redirectOnExitUrl, $cssUrl = null)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('courseid' => $courseId);
        if(isset($redirectOnExitUrl))
		{
            $params['redirecturl'] = $redirectOnExitUrl;
		}
        if(isset($cssUrl))
		{
            $params['cssurl'] = $cssUrl;
		} 
		$request->SetMethodParams($params);
			
        return $request->ConstructUrl("rustici.course.preview");
    }

    /// <summary>
    /// Gets the url to view/edit the package properties for this course.  Typically
    /// used within an IFRAME
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <returns>Signed URL to package property editor</returns>
    /// <param name="notificationFrameUrl">Tells the property editor to render a sub-iframe
    /// with the provided url as the src.  This can be used to simulate an "onload"
    /// by using a notificationFrameUrl that's the same domain as the host system and
    /// calling parent.parent.method()</param>
    public function GetPropertyEditorUrl($courseId, $stylesheetUrl, $notificationFrameUrl)
    {
        // The local parameter map just contains method methodParameters.  We'll
        // now create a complete parameter map that contains the web-service
        // params as well the actual method params.
		$request = new ServiceRequest($this->_configuration);

        $parameterMap = array('courseid' => $courseId);
		$parameterMap['editor'] = "latest";

        if(isset($notificationFrameUrl)){
            $parameterMap['notificationframesrc'] = $notificationFrameUrl;
		}
        if(isset($stylesheetUrl)){
            $parameterMap['cssurl'] = $stylesheetUrl;
		}

        $request->setMethodParams($parameterMap);
        return $request->ConstructUrl("rustici.course.properties");
    }

    /// <summary>
    /// Get the url that can be targeted by a form to upload and import a course into SCORM Cloud
    /// </summary>
    /// <param name="courseId">Unique Course Identifier</param>
    /// <param name="redirectUrl">the url location the browser will be redirected to when the import is finished</param>
    public function GetImportCourseUrl($courseId, $redirectUrl)
    {
    	$request = new ServiceRequest($this->_configuration);
    	$params = array('courseid' => $courseId,
    					'redirecturl' => $redirectUrl);
    	$request->setMethodParams($params);
    	return $request->ConstructUrl('rustici.course.importCourse');
    }
    
    
    public function GetUpdateAssetsUrl($courseId, $redirectUrl)
    {
    	$request = new ServiceRequest($this->_configuration);
    	$params = array('courseid' => $courseId,
    					'redirecturl' => $redirectUrl);
    	$request->setMethodParams($params);
    	return $request->ConstructUrl('rustici.course.updateAssets');
    }
    
    /// <summary>
    /// Retrieve the list of course attributes associated with a specific version
    /// of the specified course.
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="versionId">Specific version the specified course</param>
    /// <returns>Dictionary of all attributes associated with this course</returns>
    public function GetAttributes($courseId, $versionId=Null)
    {
		$request = new ServiceRequest($this->_configuration);
        $params = array('courseid' => $courseId);
        
		if (isset($versionId))
            $params["versionid"] = $versionId;

		$request->setMethodParams($params);
        $response = $request->CallService("rustici.course.getAttributes");

		$xmlAtts = simplexml_load_string($response);
		$atts = array();
        foreach ($xmlAtts->attributes->attribute as $attribute)
        {
			$name = (string)$attribute["name"];
            $atts[$name] = $attribute["value"];
        }
		return $atts;
    }

    /// <summary>
    /// Update the specified attributes (name/value pairs)
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="versionId">Specific version the specified course</param>
    /// <param name="attributePairs">Map of name/value pairs</param>
    /// <returns>Dictionary of changed attributes</returns>
    public function UpdateAttributes($courseId, $versionId, $attributePairs)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('courseid' => $courseId);
		
		if (isset($versionId))
            $params["versionid"] = $versionId;
		
            
        foreach ($attributePairs as $key => $value)
        {
            $params[$key] = $value;
        }

		$request->setMethodParams($params);
		$response = $request->CallService("rustici.course.updateAttributes");

        $xmlAtts = simplexml_load_string($response);
		$atts = array();
        foreach ($xmlAtts->attributes->attribute as $attribute)
        {
            $name = (string)$attribute["name"];
            $atts[$name] = $attribute["value"];
        }
		return $atts;
        
    }

    /// <summary>
    /// Update the assets of the specified course
    /// </summary>
    /// <param name="courseId">Unique Identifier for the course</param>
    /// <param name="uploadLocation">The relative path to the uploaded zip file</param>
    public function UpdateAssetsFromUploadedFile($courseId, $uploadLocation)
    {
    	$request = new ServiceRequest($this->_configuration);
    	$params = array('courseid' => $courseId, 'path' => $uploadLocation);
    	
    	$request->setMethodParams($params);
    	$response = $request->CallService('rustici.course.updateAssets');
    	
    	return $response;
    }
 }

?>
