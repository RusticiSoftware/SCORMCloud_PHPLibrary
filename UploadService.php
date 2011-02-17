<?php

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



	public function GetUploadLink($importRedirectUrl)
	{
		return GetUploadUrl($importRedirectUrl);
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
}

?>