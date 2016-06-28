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

/**
 * @version $Id$
 * @author  Jason Wisener <jason.wisener@scorm.com>
 * @license http://opensource.org/licenses/lgpl-license.php
 *          GNU Lesser General Public License, Version 2.1
 * @package RusticiSoftware.ScormEngine.Cloud
 */

require_once (dirname(__FILE__) . '/2015Adapter/CourseServiceToCourseApiAdapter.php');
require_once (dirname(__FILE__) . '/2015Adapter/RegistrationServiceToRegistrationApiAdapter.php');
require_once (dirname(__FILE__) . '/2015Adapter/DebugServiceToPingApiAdapter.php');
require_once 'DebugService.php';

class ScormEngineService{

	private $_configuration = null;
    private $_courseService = null;
    private $_registrationService = null;
	private $_debugService = null;

	public function __construct($scormEngineServiceUrl,
                                $appId,
                                $securityKey,
                                $originString,
                                $proxy=null,
                                $appManager=null,
                                $managerKey=null) {

		$this->_configuration = new Configuration($scormEngineServiceUrl, $appId, $securityKey, $appManager, $managerKey, $originString);
        $this->_configuration->setProxy($proxy);
        $this->_courseService = new CourseServiceToCourseApiAdapter($this->_configuration);
        $this->_registrationService = new RegistrationServiceToRegistrationApiAdapter($this->_configuration);
		$this->_debugService = new DebugServiceToPingApiAdapter($this->_configuration);
	}
	
    public function isValidAccount() {
        $appId = $this->getAppId();
        $key = $this->getSecurityKey();
        $url = $this->getScormEngineServiceUrl();
        $origin = $this->getOriginString();
        if (empty($appId) || empty($key) || empty($url) || empty($origin)) {
            return false;
        }
        
        return $this->_debugService->CloudAuthPing();
    }
    
    public function isValidUrl(){
        return $this->_debugService->CloudPing();
    }

	/**
	* <summary>
    * Contains all SCORM Engine Package-level (i.e., course) functionality.
    * </summary>
	*/
    public function getCourseService()
    {
        return $this->_courseService;
    }

	/**
	* <summary>
    * Contains all SCORM Engine Package-level (i.e., course) functionality.
    * </summary>
	*/
    public function getRegistrationService()
    {
        return $this->_registrationService;
    }

    /**
     * <summary>
     * Contains SCORM Engine debug functionality.
     * </summary>
     */
    public function getDebugService()
    {
        return $this->_debugService;
    }


	/**
	* <summary>
    * Contains all SCORM Engine Upload/File Management functionality.
    * </summary>
	*/
    public function getUploadService()
    {
		throw new Exception("UploadService is not supported.");
    }

	/**
	* <summary>
    * Contains all SCORM Engine Reportage functionality.
    * </summary>
	*/
    public function getReportingService()
    {
        throw new Exception("reporting service is not supported.");
    }

	/**
	* <summary>
    * Contains all SCORM Engine FTP Management functionality.
    * </summary>
	*/
    public function getFtpService()
    {
        throw new Exception("FtpService is not supported.");
    }
    
    /**
	* <summary>
    * Contains SCORM Engine tagging functionality.
    * </summary>
	*/
    public function getTaggingService()
    {
        throw new Exception("TaggingService is no longer supported.");
    }
    
    /**
	* <summary>
    * Contains SCORM Engine account info retrieval functionality.
    * </summary>
	*/
    public function getAccountService()
    {
        throw new Exception("AccountService is not supported at this time.");
    }

	/**
	* <summary>
    * Contains SCORM Engine dispatch functionality.
    * </summary>
	*/
    public function getDispatchService()
    {
		throw new Exception("DispatchService is not supported at this time.");
    }

	/**
	* <summary>
    * Contains SCORM Engine Invitation functionality.
    * </summary>
	*/
    public function getInvitationService()
    {
		throw new Exception("InvitationService is not supported at this time.");
    }

    /**
    * <summary>
    * Contains SCORM Engine Activity provider functionality.
    * </summary>
    */
    public function getLrsAccountService()
    {
		throw new Exception("LrsAccountService is not supported at this time.");
    }

    /**
    * <summary>
    * Contains SCORM Engine Activity provider functionality.
    * </summary>
    */
    public function getApplicationService()
    {
		throw new Exception("ApplicationService is not supported at this time.");
    }

	/**
	* <summary>
    * The Application ID obtained by registering with the SCORM Engine Service
    * </summary>
	*/
    public function getAppId()
    {
            return $this->_configuration->getAppId();
    }

	/**
	* <summary>
    * The security key (password) linked to the Application ID
    * </summary>
	*/
    public function getSecurityKey()
    {
            return $this->_configuration->getSecurityKey();
    }

	/**
	* <summary>
    * URL to the service, ex: http://services.scorm.com/EngineWebServices
    * </summary>
	*/
    public function getScormEngineServiceUrl()
    {
            return $this->_configuration->getScormEngineServiceUrl();
    }
    
    public function getOriginString()
    {
        return $this->_configuration->getOriginString();
    }

	/**
	* <summary>
    * CreateNewRequest
    * </summary>
	*/
    public function CreateNewRequest()
    {
		throw new Exception("ServiceRequest is not supported at this time.");
    }
}
?>
