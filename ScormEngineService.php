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
 * @author  Brian Rogers <brian.rogers@scorm.com>
 * @license http://opensource.org/licenses/lgpl-license.php
 *          GNU Lesser General Public License, Version 2.1
 * @package RusticiSoftware.ScormEngine.Cloud
 */

require_once 'Configuration.php';
require_once 'ServiceRequest.php';
require_once 'CourseService.php';
require_once 'InvitationService.php';
require_once 'RegistrationService.php';
require_once 'UploadService.php';
require_once 'ReportingService.php';
require_once 'TaggingService.php';
require_once 'AccountService.php';
require_once 'DebugService.php';
require_once 'DispatchService.php';
require_once 'LrsAccountService.php';
require_once 'ApplicationService.php';

require_once 'DebugLogger.php';


class ScormEngineService{

	private $_configuration = null;
    private $_courseService = null;
    private $_registrationService = null;
    private $_uploadService = null;
    private $_ftpService = null;
	private $_serviceRequest = null;
    private $_taggingService = null;
    private $_accountService = null;
	private $_debugService = null;
    private $_dispatchService = null;
	private $_invitationService = null;
    private $_lrsAccountService = null;
    private $_applicationService = null;

	public function __construct($scormEngineServiceUrl, $appId, $securityKey, $originString, $proxy=null, $appManager=null, $managerKey=null) {
		$this->_configuration = new Configuration($scormEngineServiceUrl, $appId, $securityKey, $appManager, $managerKey, $originString);
        $this->_configuration->setProxy($proxy);
		$this->_serviceRequest = new ServiceRequest($this->_configuration);
        $this->_courseService = new CourseService($this->_configuration);
        $this->_registrationService = new RegistrationService($this->_configuration);
        $this->_uploadService = new UploadService($this->_configuration);
		$this->_reportingService = new ReportingService($this->_configuration);
        $this->_taggingService = new TaggingService($this->_configuration);
        $this->_accountService = new AccountService($this->_configuration);
		$this->_debugService = new DebugService($this->_configuration);
        $this->_dispatchService = new DispatchService($this->_configuration);
		$this->_invitationService = new InvitationService($this->_configuration);
        $this->_lrsAccountService = new LrsAccountService($this->_configuration);
        $this->_applicationService = new ApplicationService($this->_configuration);
        //$_ftpService = new FtpService(configuration);
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
    * Contains all SCORM Engine Upload/File Management functionality.
    * </summary>
	*/
    public function getUploadService()
    {
        return $this->_uploadService;
    }

	/**
	* <summary>
    * Contains all SCORM Engine Reportage functionality.
    * </summary>
	*/
    public function getReportingService()
    {
        return $this->_reportingService;
    }

	/**
	* <summary>
    * Contains all SCORM Engine FTP Management functionality.
    * </summary>
	*/
    public function getFtpService()
    {
        return $this->_ftpService;
    }
    
    /**
	* <summary>
    * Contains SCORM Engine tagging functionality.
    * </summary>
	*/
    public function getTaggingService()
    {
        return $this->_taggingService;
    }
    
    /**
	* <summary>
    * Contains SCORM Engine account info retrieval functionality.
    * </summary>
	*/
    public function getAccountService()
    {
        return $this->_accountService;
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
    * Contains SCORM Engine dispatch functionality.
    * </summary>
	*/
    public function getDispatchService()
    {
        return $this->_dispatchService;
    }

	/**
	* <summary>
    * Contains SCORM Engine Invitation functionality.
    * </summary>
	*/
    public function getInvitationService()
    {
        return $this->_invitationService;
    }

    /**
    * <summary>
    * Contains SCORM Engine Activity provider functionality.
    * </summary>
    */
    public function getLrsAccountService()
    {
        return $this->_lrsAccountService;
    }

    /**
    * <summary>
    * Contains SCORM Engine Activity provider functionality.
    * </summary>
    */
    public function getApplicationService()
    {
        return $this->_applicationService;
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
        return new ServiceRequest($this->_configuration);
    }
}
?>
