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
require_once 'UploadToken.php';
require_once 'DebugLogger.php';

/// <summary>
/// Client-side proxy for the "rustici.course.*" Hosted SCORM Engine web
/// service methods.  
/// </summary>
class UploadService{
	
	private $_configuration = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
		//echo $this->_configuration->getAppId();
	}
	
	public function GetUploadToken()
    {
		write_log('rustici.upload.getUploadToken being called...');
        $request = new ServiceRequest($this->_configuration);
        $response = $request->CallService("rustici.upload.getUploadToken");
		write_log('rustici.upload.getUploadToken returned : '.$response);
        return new UploadToken($response);
    }


    public function UploadFile($absoluteFilePathToZip, $permissionDomain = null)
    {
		write_log('UploadService.UploadFile() being called...');
        $token = $this->GetUploadToken();

        $request = new ServiceRequest($this->_configuration);
        $request->setFileToPost($absoluteFilePathToZip);
		write_log('rustici.upload.uploadFile : fileToPost='.$absoluteFilePathToZip);
        
		$mParams = array('token' => $token->getTokenId());
	

        if (isset($permissionDomain)) {
            $mParams["pd"] = $permissionDomain;
        }

		$request->setMethodParams($mParams);
		
		write_log('rustici.upload.uploadFile being called...');
        $response = $request->CallService("rustici.upload.uploadFile");
		write_log('rustici.upload.getUploadToken returned : '.$response);

		$xml = simplexml_load_string($response);
		if (false === $xml) {
            write_log('UploadService.UploadFile : xml parsing error : '.$xml);
        }

        $location = $xml->location;

		write_log('UploadService.UploadFile() completed : '.$location);
        return $location;
    }
    
    public function DeleteFile($location){
    	$location_parts = explode("/", $location);
    	write_log('UploadService.DeleteFile() being called...');
    	$request = new ServiceRequest($this->_configuration);
    	$params = array('file' => $location_parts[1]);
    	$request->setMethodParams($params);
    	$response = $request->CallService("rustici.upload.deleteFiles");
    }

	public function GetUploadUrl($importRedirectUrl)
		{
		write_log('UploadService.GetUploadLink() being called...');
        $token = $this->GetUploadToken();
		
        $request = new ServiceRequest($this->_configuration);

		$mParams = array('token' => $token->getTokenId());
		$mParams["redirecturl"] = $importRedirectUrl;
		$request->setMethodParams($mParams);
		
		return $request->ConstructUrl("rustici.upload.uploadFile");

	}

	public function GetUploadLink($importRedirectUrl)
	{
		return $this->GetUploadUrl($importRedirectUrl);
	}
}

?>
