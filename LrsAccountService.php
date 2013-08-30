<?php

/* Software License Agreement (BSD License)
 * 
 * Copyright (c) 2013, Rustici Software, LLC
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
require_once 'LrsAccount.php';

/// <summary>
/// Client-side proxy for the "rustici.lrsaccont.*" Hosted SCORM Engine web
/// service methods.  
/// </summary>
class LrsAccountService{
	
	private $_configuration = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
	}
	
	/// <summary>
    /// Create new Activity Provider
    /// <returns>Created activity provider</returns>
    public function createActivityProvider()
    {
    	$request = new ServiceRequest($this->_configuration);
        $response = $request->CallService("rustici.lrsaccount.createActivityProvider");

        write_log('rustici.lrsaccont.createActivityProvider : '.$response);
        
        $lrsAccountResult = new LrsAccount($response);
    	
    	return $lrsAccountResult;
    }
    
    
    /// <summary>
     /// Get a list of all activity providers
     /// </summary>
     
     /// <returns>List of Activity Providers</returns>
     public function listActivityProviders()
     {
        $request = new ServiceRequest($this->_configuration);
        $response = $request->CallService("rustici.lrsaccount.listActivityProviders");

        write_log('rustici.lrsaccount.listActivityProviders : '.$response);
        
        $lrsAccountResult = LrsAccount::ConvertToLrsAcountList($response);
        
        return $lrsAccountResult;
     }

     /// <summary>
     /// edit activity provider.
     /// </summary>
     
     /// <returns>Activity Provider</returns>
     public function editActivityProvider($accountKey, $isActive = null, $authType = null, $label = null)
     {
        $request = new ServiceRequest($this->_configuration);

        $params = array('accountkey'=>$accountKey);
                            
        
        if(isset($isActive))
        {
            $params['isactive'] = $isActive;
        }
        if(isset($authType))
        {
            $params['authtype'] = $authType;
        }
        if (isset($label)) 
        {
            $params['label'] = $label;
        }

        $request->setMethodParams($params);
        $response = $request->CallService("rustici.lrsaccount.editActivityProvider");

        write_log('rustici.lrsaccount.editActivityProviders : '.$response);
        
        $lrsAccountResult = new LrsAccount($response);
        
        return $lrsAccountResult;
     }


     /// <summary>
     /// delete specified activity provider
     /// </summary>
     
     public function deleteActivityProvider($accountKey)
     {
        $request = new ServiceRequest($this->_configuration);
        $params = array('accountkey'=>$accountKey);

        $request->setMethodParams($params);
        $response = $request->CallService("rustici.lrsaccount.deleteActivityProvider");

        write_log('rustici.lrsaccount.deleteActivityProvider : '.$response);
     }

     /// <summary>
     /// Set App Lrs Auth Callback URL. 
     /// </summary>
     public function setAppLrsAuthCallbackUrl($callBackUrl)
     {
        $request = new ServiceRequest($this->_configuration);

        $params = array('lrsAuthCallbackUrl'=>$callBackUrl);

        $request->setMethodParams($params);
        $response = $request->CallService("rustici.lrsaccount.setAppLrsAuthCallbackUrl");

        write_log('rustici.lrsaccont.setAppLrsAuthCallbackUrl : '.$response);
     }


 }

?>
