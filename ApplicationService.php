<?php

/* Software License Agreement (BSD License)
 * 
 * Copyright (c) 2010-2014, Rustici Software, LLC
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


require_once 'Enums.php';
require_once 'LaunchInfo.php';
require_once 'DebugLogger.php';

	/// <summary>
   	/// Client-side proxy for the "rustici.Application.*" Hosted SCORM Engine web
   	/// service methods.  
   	/// </summary>
class ApplicationService{
	
	private $_configuration = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
		//echo $this->_configuration->getAppId();
	}

        /// <summary>
        /// Create a new Application 
        /// </summary>
        /// <param name="name">Unique Identifier for the Application</param>
        public function CreateApplication($name)
        {
            $request = new ServiceRequest($this->_configuration);
			$params = array('name'=>$name);
			$request->setMethodParams($params);
            return $request->CallManagerService("rustici.application.createApplication");
        }

        /// <summary>
        /// Update application configuration
        /// </summary>
        /// <param name="appId">The child app id to be updated</param>
        /// <param name="name">Unique Identifier for the Application</param>
        /// <param name="allowDelete">True/False: whether registration delete operations enabled</param>
        /// <returns></returns>
        public function UpdateApplication($appId, $name = null, $allowDelete = null)
        {
            $request = new ServiceRequest($this->_configuration);
            $params = array('appid' => $appId);
            if (isset($name))
            {
                $params['name'] = $name;
            }
            if (isset($allowDelete))
            {
                $params['allowDelete'] = $allowDelete;
            }
            
            $request->setMethodParams($params);

            $response = $request->CallManagerService("rustici.application.updateApplication");
            return $response;
        }
        
        /// <summary>
        /// Returns a list of Application id's along with their associated data
        /// </summary>
        /// <returns></returns>
        public function GetAppList()
        {
            $request = new ServiceRequest($this->_configuration);
            $params = array();
            $request->setMethodParams($params);

            $response = $request->CallManagerService("rustici.application.getAppList");
            $appData = new ApplicationData(null);
            // Return the subset of the xml starting with the top <summary>
            $appArray = $appData->ConvertToApplicationDataList($response);
            return $appArray;
        }
        
        /// <summary>
        /// Returns the detail of a Application
        /// <param name="appId">The child app id to be updated</param>
        /// </summary>
        /// <returns></returns>
        public function GetAppInfo($appId)
        {
			$request = new ServiceRequest($this->_configuration);
			$params = array('appid' => $appId);
			$request->setMethodParams($params);
            $response = $request->CallManagerService("rustici.application.getAppInfo");
            return $response;
        }

        /// <summary>
        /// Add a secret key
        /// </summary>
        /// <param name="description">Description for new secret key</param>
        public function AddSecretKey($appId, $description)
        {
            $request = new ServiceRequest($this->_configuration);
            $params = array('name'=>$ApplicationId,
                            'description'=>$description);
            $request->setMethodParams($params);
            return $request->CallManagerService("rustici.application.AddSecretKey");
        }

        /// <summary>
        /// Update secret key configuration
        /// </summary>
        /// <param name="appId">The child app id to be updated</param>
        /// <param name="keyId">The secret key id to be updated</param>
        /// <param name="description">Description for new secret key</param>
        /// <param name="active">True/False: whether this key can authorize API actions for this app</param>
        /// <returns></returns>
        public function UpdateSecretKey($appId, $keyId, $description = null, $active = null)
        {
            $request = new ServiceRequest($this->_configuration);
            $params = array('appid' => $appId,
                            'secretkeyid' => $keyId);
            if (isset($description))
            {
                $params['description'] = $description;
            }
            if (isset($allowDelete))
            {
                $params['active'] = $active;
            }
            
            $request->setMethodParams($params);

            $response = $request->CallManagerService("rustici.application.updateSecretKey");
            return $response;
        }

        /// <summary>
        /// Delete the specified secret key
        /// </summary>
        /// <param name="appId">The child app id to be updated</param>
        /// <param name="keyId">The secret key id to be updated</param>
        public function DeleteSecretKey($appid, $keyId)
        {
            $request = new ServiceRequest($this->_configuration);
            $params = array('appid' => $appid,
                            'secretkeyid' => $keyId);
			$request->SetMethodParams($params);
			$request->CallService("rustici.application.deleteSecretKey");
        }
}
