<?php

require_once 'ServiceRequest.php';
require_once 'DebugLogger.php';

/// <summary>
/// Client-side proxy for the "rustici.course.*" Hosted SCORM Engine web
/// service methods.  
/// </summary>
class AccountService{
	
	private $_configuration = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
		//echo $this->_configuration->getAppId();
	}

	public function GetAccountInfo(){
		$request = new ServiceRequest($this->_configuration);
		$params = array('appid' => $this->_configuration->getAppId());
		$request->setMethodParams($params);
       	$response = $request->CallService("rustici.reporting.getAccountInfo");
        //error_log($response);
       	return $response;
	}
    
    
}

?>