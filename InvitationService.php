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
require_once 'Enums.php';
require_once 'DebugLogger.php';

/// <summary>
/// Client-side proxy for the "rustici.course.*" Hosted SCORM Engine web
/// service methods.  
/// </summary>
class InvitationService{
	
	private $_configuration = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
		//echo $this->_configuration->getAppId();
	}
	
	/// <summary>
    /// Create a new SCORm Cloud invitation
    /// </summary>
    /// <param name="courseId">Unique Identifier for this course.</param>
    /// <param name="addresses">comma-delimited list of email addresses to which invitations should be sent 
    /// for ftp access service (see ftp service below). 
    /// If the domain specified does not exist, the course will be placed in the default permission domain</param>
    /// <returns>List of Import Results</returns>
    public function CreateInvitation($courseId, $publicInvitation = 'true', $send = 'true',
 									$addresses = null, $emailSubject = null, $emailBody = null, $creatingUserEmail = null,
									$registrationCap = null, $postbackUrl = null, $authType = null, $urlName = null, $urlPass = null,
									$resultsFormat = null, $async = false)
    {
		$request = new ServiceRequest($this->_configuration);
        $params = array('courseid' => $courseId);
		$params['send'] = $send;
		$params['public'] = $publicInvitation;
		
		if (isset($addresses))
		{
            $params['addresses'] = $addresses;
		}
		if (isset($emailSubject))
		{
            $params['emailSubject'] = $emailSubject;
		}
		if (isset($emailBody))
		{
            $params['emailBody'] = $emailBody;
		}
		if (isset($creatingUserEmail))
		{
            $params['creatingUserEmail'] = $creatingUserEmail;
		}
		if (isset($registrationCap))
		{
            $params['registrationCap'] = $registrationCap;
		}
		if (isset($postbackUrl))
		{
            $params['postbackUrl'] = $postbackUrl;
		}
		if (isset($authType))
		{
            $params['authType'] = $authType;
		}
		if (isset($urlName))
		{
            $params['urlName'] = $urlName;
		}
		if (isset($urlPass))
		{
            $params['urlPass'] = $urlPass;
		}
		if (isset($resultsFormat))
		{
            $params['resultsFormat'] = $resultsFormat;
		}
		
		$request->setMethodParams($params);
		if ($async){
			$response = $request->CallService("rustici.invitation.createInvitationAsync");
		} else {
			$response = $request->CallService("rustici.invitation.createInvitation");
		}
        return $response;
    }

	

	public function GetInvitationList($filter = null, $coursefilter = null)
    {
		$request = new ServiceRequest($this->_configuration);
		$params = array();
		
		if (isset($filter))
		{
            $params['filter'] = $filter;
		}
		
        if (isset($coursefilter))
		{
            $params['coursefilter'] = $coursefilter;
		}
        $request->setMethodParams($params);
        $response = $request->CallService("rustici.invitation.getInvitationList");
        return $response;
    }

	public function GetInvitationStatus($invitationId)
    {
		$request = new ServiceRequest($this->_configuration);
		$params = array();
		
		$params['invitationId'] = $invitationId;
		
        
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.invitation.getInvitationStatus");
        return $response;
    }
	

	public function GetInvitationInfo($invitationId, $detail = null)
    {
		$request = new ServiceRequest($this->_configuration);
		$params = array();
		
		$params['invitationId'] = $invitationId;
		
        if (isset($detail))
		{
            $params['detail'] = $detail;
		}
        
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.invitation.getInvitationInfo");
        return $response;
    }

	public function ChangeStatus($invitationId, $enable, $open = null)
    {
		$request = new ServiceRequest($this->_configuration);
		$params = array();
		
		$params['invitationId'] = $invitationId;
		$params['enable'] = $enable;
		
        if (isset($open))
		{
            $params['open'] = $open;
		}
        
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.invitation.changeStatus");
        return $response;
    }
    
    
 }

?>
