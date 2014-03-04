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


require_once 'RegistrationData.php';
require_once 'Enums.php';
require_once 'LaunchInfo.php';
require_once 'RegistrationSummary.php';
require_once 'DebugLogger.php';

	/// <summary>
   	/// Client-side proxy for the "rustici.registration.*" Hosted SCORM Engine web
   	/// service methods.  
   	/// </summary>
class RegistrationService{
	
	private $_configuration = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
		//echo $this->_configuration->getAppId();
	}

        /// <summary>
        /// Create a new Registration (Instance of a user taking a course)
        /// </summary>
        /// <param name="registrationId">Unique Identifier for the registration</param>
        /// <param name="courseId">Unique Identifier for the course</param>
        /// <param name="learnerId">Unique Identifier for the learner</param>
        /// <param name="learnerFirstName">Learner's first name</param>
        /// <param name="learnerLastName">Learner's last name</param>
        public function CreateRegistration($registrationId, $courseId, $learnerId, $learnerFirstName, 
											$learnerLastName,$email = null, $authtype = null, $resultsformat = 'xml',
											$resultsPostbackUrl = null, $postBackLoginName = null, 
											$postBackLoginPassword = null, $versionId = null)
        {
            $request = new ServiceRequest($this->_configuration);

			$params = array('regid'=>$registrationId,
							'courseid'=>$courseId,
							'fname'=>$learnerFirstName,
							'lname'=>$learnerLastName,
							'learnerid'=>$learnerId);
							
			
			if(isset($email))
			{
				$params['email'] = $email;
			}
			if(isset($authtype))
			{
				$params['authtype'] = $authtype;
			}
			if(isset($resultsformat))
			{
				$params['resultsformat'] = $resultsformat;
			}
			//Optional Arguments
			if(isset($resultsPostbackUrl))
			{
				$params['postbackurl'] = $resultsPostbackUrl;
			}
			if(isset($postBackLoginName))
			{
				$params['urlname'] = $postBackLoginName;
			}
			if(isset($postBackLoginPassword))
			{
				$params['urlpass'] = $postBackLoginPassword;
			}
			if(isset($versionId))
			{
				$params['versionid'] = $versionId;
			}
			
			$request->setMethodParams($params);
			
            return $request->CallService("rustici.registration.createRegistration");
        }

        public function Exists($registrationId) {
            $request = new ServiceRequest($this->_configuration);
            $params = array('regid'=>$registrationId);
            $request->setMethodParams($params);
            $response = $request->CallService("rustici.registration.exists");
            $xml = simplexml_load_string($response);
            write_log($xml->result);
            return ($xml->result == 'true');
        }
  
        /// <summary>
        /// Returns the current state of the registration, including completion
        /// and satisfaction type data.  Amount of detail depends on format parameter.
        /// </summary>
        /// <param name="registrationId">Unique Identifier for the registration</param>
        /// <param name="resultsFormat">Degree of detail to return</param>
        /// <returns>Registration data in XML Format</returns>
        public function GetRegistrationResult($registrationId, $resultsFormat, $dataFormat)
        {
			$enum = new Enum();
            $request = new ServiceRequest($this->_configuration);
			$params = array('regid' => $registrationId,
							'resultsformat' => $enum->getRegistrationResultsFormat($resultsFormat),
							'dataformat' => $enum->getDataFormat($dataFormat)
							);
			$request->setMethodParams($params);
            $response = $request->CallService("rustici.registration.getRegistrationResult");

            // Return the subset of the xml starting with the top <summary>
            return $response;
        }

		public function GetRegistrationResultUrl($registrationId, $resultsFormat, $dataFormat)
		{
			$enum = new Enum();
			$request = new ServiceRequest($this->_configuration);
			$params = array('regid' => $registrationId,
							'resultsformat' => $enum->getRegistrationResultsFormat($resultsFormat),
							'dataformat' => $enum->getDataFormat($dataFormat)
							);

			$request->setMethodParams($params);

	        return $request->ConstructUrl("rustici.registration.getRegistrationResult");
		}

        /// <summary>
        /// Return a registration summary object for the given registration
        /// </summary>
        /// <param name="registrationId">The unique identifier of the registration</param>
        /// <returns></returns>
        public function GetRegistrationSummary($registrationId)
        {
            $request = new ServiceRequest($this->_configuration);
			$params = array('regid' => $registrationId,
							'resultsformat' => 'course',
							'dataformat' => 'xml'
							);
			$request->setMethodParams($params);

            $response = $request->CallService("rustici.registration.getRegistrationResult");
			$xml = simplexml_load_string($response);
            $reportElem = $xml->registrationreport;
            return new RegistrationSummary($reportElem);
        }
        
        
        /// <summary>
        /// Returns a list of registration id's along with their associated course
        /// </summary>
        /// <param name="courseId>Option course id filter</param>
        /// <param name="learnerId>Option learner id filter</param>
        /// <returns></returns>
        public function GetRegistrationList($courseId, $learnerId)
        {
            $request = new ServiceRequest($this->_configuration);
	    $params = array();
            if (isset($courseId))
	      {
		$params['courseid'] = $courseId;
	      }
	    if (isset($learnerId))
	      {
		$params['learnerid'] = $learnerId;
	      }
            $request->setMethodParams($params);

            $response = $request->CallService("rustici.registration.getRegistrationList");
	    $regData = new RegistrationData(null);
            // Return the subset of the xml starting with the top <summary>
	    $regArray = $regData->ConvertToRegistrationDataList($response);
	    return $regArray;
        }
        
        /// <summary>
        /// Returns the detail of a registration
        /// </summary>
        /// <param name="regIdFilterRegex">Optional registration id filter</param>
        /// <returns></returns>
        public function GetRegistrationDetail($registrationId)
        {
			$request = new ServiceRequest($this->_configuration);
			$params = array('regid' => $registrationId);
			$request->setMethodParams($params);
            $response = $request->CallService("rustici.registration.getRegistrationDetail");
            return $response;
        }
        
        /// <summary>
        /// Returns a list of registration id's along with their associated course
        /// </summary>
        /// <param name="courseId">Option course id filter</param>
        /// <param name="learnerId">Optional learner id filter</param>
        /// <param name="resultsFormat">Optional set format of results</param>
        /// <returns></returns>
        public function GetRegistrationListResults($courseId, $learnerId, $resultsFormat)
        {
            $enum = new Enum();
            $request = new ServiceRequest($this->_configuration);
	    $params = array();
            if (isset($courseId))
	      {
                $params['courseid'] = $courseId;
	      }
            if (isset($learnerId))
	      {
		$params['learnerid'] = $learnerId;
	      }
            if (isset($resultsFormat))
	      {
		$params['resultsformat'] = $enum->getRegistrationResultsFormat($resultsFormat);
	      }
            
            $request->setMethodParams($params);

            $response = $request->CallService("rustici.registration.getRegistrationListResults");
	    return $response;
        }


        /// <summary>
        /// Delete the specified registration
        /// </summary>
        /// <param name="registrationId">Unique Identifier for the registration</param>
        /// <param name="deleteLatestInstanceOnly">If false, all instances are deleted</param>
        public function DeleteRegistration($registrationId, $deleteLatestInstanceOnly=False)
        {
            $request = new ServiceRequest($this->_configuration);
            $params = array('regid' => $registrationId);
            if ($deleteLatestInstanceOnly)
			{
                $params['instanceid'] = "latest";
            }
			$request->SetMethodParams($params);
			$request->CallService("rustici.registration.deleteRegistration");
        }


        /// <summary>
        /// Resets all status data regarding the specified registration -- essentially restarts the course
        /// </summary>
        /// <param name="registrationId">Unique Identifier for the registration</param>
        public function ResetRegistration($registrationId)
        {
            $request = new ServiceRequest($this->_configuration);
			$params = array('regid'=>$registrationId);
            $request->SetMethodParams($params);
            $request->CallService("rustici.registration.resetRegistration");
        }

        /// <summary>
        /// Clears global objective data for the given registration
        /// </summary>
        /// <param name="registrationId">Unique Identifier for the registration</param>
        /// <param name="deleteLatestInstanceOnly">If false, all instances are deleted</param>
        public function ResetGlobalObjectives($registrationId, $deleteLatestInstanceOnly=true)
        {
            $request = new ServiceRequest($this->_configuration);
            $params = array('regid'=>$registrationId);
            if ($deleteLatestInstanceOnly)
			{
				$params['instanceid'] = 'latest';
 			}
			$request->SetMethodParams($params);
			$request->CallService("rustici.registration.resetGlobalObjectives");
        }
        /// <summary>
        /// Delete the specified instance of the registration
        /// </summary>
        /// <param name="registrationId">Unique Identifier for the registration</param>
        /// <param name="instanceId">Specific instance of the registration to delete</param>
        public function DeleteRegistrationInstance($registrationId, $instanceId)
        {
            $request = new ServiceRequest($this->_configuration);
            $params = array('regid' => $registrationId,
							'instanceid' => $instanceId );
          	$request->SetMethodParams($params);
            $request->CallService("rustici.registration.deleteRegistration");
        }


        /// <summary>
        /// Gets the url to directly launch/view the course registration in a browser
        /// </summary>
        /// <param name="registrationId">Unique Identifier for the registration</param>
        /// <param name="redirectOnExitUrl">Upon exit, the url that the SCORM player will redirect to</param>
        /// <param name="cssUrl">Absolute url that points to a custom player style sheet</param>
		/// <param name="debugLogPointerUrl">Url that the server will postback a "pointer" url regarding
        /// a saved debug log that resides on s3</param>
        /// <returns>URL to launch</returns>
        public function GetLaunchUrl($registrationId, $redirectOnExitUrl=null, $cssUrl=null, $debugLogPointerUrl=null,$courseTags=null, $learnerTags=null, $registrationTags=null)
        {
            $request = new ServiceRequest($this->_configuration);
			$params = array('regid' => $registrationId);
            
            if(isset($redirectOnExitUrl))
			{
                $params['redirecturl'] = $redirectOnExitUrl;
			} 
            if(isset($cssUrl))
			{
                $params['cssurl'] = $cssUrl;
			} 
			if(isset($debugLogPointerUrl))
			{
				$params['saveDebugLogPointerUrl'] = $debugLogPointerUrl;			
			}
            if(isset($courseTags))
			{
				$params['courseTags'] = $courseTags;		
			}
            if(isset($learnerTags))
			{
				$params['learnerTags'] = $learnerTags;		
			}
            if(isset($registrationTags))
			{
				$params['registrationTags'] = $registrationTags;		
			}

			$request->setMethodParams($params);
           	return $request->ConstructUrl("rustici.registration.launch");
        }
	
	
	/// <summary>
    /// Returns list of launch info objects, each of which describe a particular launch,
    /// but note, does not include the actual history log for the launch. To get launch
    /// info including the log, use GetLaunchInfo
    /// </summary>
    /// <param name="registrationId"></param>
    /// <returns>LaunchHistory XML</returns>
    public function GetLaunchHistory($registrationId)
    {
        $request = new ServiceRequest($this->_configuration);
		$params = array('regid' => $registrationId);
		$request->setMethodParams($params);
        
        $response = $request->CallService("rustici.registration.getLaunchHistory");

		$historyArray = LaunchInfo::ConvertToLaunchInfoList($response);
		return $historyArray;
    }

    /// <summary>
    /// Get the full launch information for the launch with the given launch id
    /// </summary>
    /// <param name="launchId"></param>
    /// <returns>LaunchInfo XML</returns>
    public function GetLaunchInfo($launchId)
    {
        $request = new ServiceRequest($this->_configuration);
		$params = array('launchid' => $launchId);
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.registration.getLaunchInfo");
        return $response;
    }

	public function UpdateLearnerInfo($learnerid,$fname,$lname,$newid=null)
	{
		$request = new ServiceRequest($this->_configuration);
		$params = array('learnerid' => $learnerid);
		$params['fname'] = $fname;
		$params['lname'] = $lname;
		if (isset($newid))
		{
			$params['newid'] = $newid;
		}
		
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.registration.updateLearnerInfo");
        return $response;
		
		
	}
}
