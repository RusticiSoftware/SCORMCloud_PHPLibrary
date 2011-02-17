<?php

require_once 'ServiceRequest.php';
require_once 'DebugLogger.php';

/// <summary>
/// Client-side proxy for the "rustici.debug.*" Hosted SCORM Engine web
/// service methods.  
/// </summary>
class DebugService{
	
	private $_configuration = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
		//echo $this->_configuration->getAppId();
	}
	
	public function CloudPing()
    {
		write_log('rustici.debug.ping being called...');
        $request = new ServiceRequest($this->_configuration);
        $response = $request->CallService("rustici.debug.ping");
		write_log('rustici.debug.ping returned : '.$response);
		$xml = simplexml_load_string($response);
		return ($xml['stat'] == 'ok');
    }

	public function CloudAuthPing()
    {
		write_log('rustici.debug.authPing being called...');
        $request = new ServiceRequest($this->_configuration);
        $response = $request->CallService("rustici.debug.authPing");
		write_log('rustici.debug.authPing returned : '.$response);
		$xml = simplexml_load_string($response);
		return ($xml['stat'] == 'ok');
    }

    
}

?>