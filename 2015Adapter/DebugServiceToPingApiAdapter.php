<?php

use RusticiSoftware\ScormContentPlayer\api\model as model;
use RusticiSoftware\Engine\Client as client;

require_once '../IDebugService.php';
require_once (dirname(__FILE__) . '/apilib/ScormEngineClient.php');

class DebugServiceToPingApiAdapter implements IDebugService
{
	private $configuration;
	private $pingApiClient;

	function __construct($configuration)
	{
		//print_R($configuration);
		$this->configuration = $configuration;

		$scormEngineApiClient = new client\ScormEngineClient($configuration->getScormEngineServiceUrl(),
			$configuration->getApiUsername(),
			$configuration->getApiPassword(),
			$configuration->getTenant());

		$this->pingApiClient = $scormEngineApiClient->GetPingApiClient();
	}

 	function CloudPing($throw = false)
 	{
		try
		{ 
			$pingData = $this->pingApiClient->getPing();
		} 
		catch (\Exception $e) 
		{
            write_log('DebugServiceToPingAdapter->CloudPing: ' . $e->getMessage());
            return false;
    	}
 		return $pingData->message == "API is up.";
 	}

	//Adapater around the ping api call, that 
	//returns the expected value for cloud/localws.
    function CloudAuthPing($throw = false)
    {
		try
		{ 
			$pingData = $this->pingApiClient->getPing();
		} 
		catch (\Exception $e) 
		{
            write_log('DebugServiceToPingAdapter->CloudPing: ' . $e->getMessage());
            return false;
    	}
 		return $pingData->message == "API is up.";
	}
}

?>