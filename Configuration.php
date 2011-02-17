<?php

class Configuration{
	
	private $_appId = null;
    private $_securityKey = null;
    private $_scormEngineServiceUrl = null;

	public function __construct($scormEngineServiceUrl, $appId, $securityKey) {
		//echo $scormEngineServiceUrl;
		//echo $appId;
		//echo $securityKey;
		// scormEngineServiceUrl (required)
		if (isset($scormEngineServiceUrl)) {
			$this->setScormEngineServiceUrl($scormEngineServiceUrl);
		} else {
			//throw new ScormEngine_Exception('Must provide a scormEngineServiceUrl.');
		}
		// appId (required)
		if (isset($appId)) {
			$this->setAppId($appId);
		} else {
			//throw new ScormEngine_Exception('Must provide an appId.');
		}
		// securityKey (required)
		if (isset($securityKey)) {
			$this->setSecurityKey($securityKey);
		} else {
			//throw new ScormEngine_Exception('Must provide a securityKey.');
		}
	}
	
	public function getAppId()
	{
		return $this->_appId;
	}
	public function setAppId($appId)
	{
		$this->_appId = $appId;
	}
	
	public function getSecurityKey()
	{
		return $this->_securityKey;
	}
	public function setSecurityKey($securityKey)
	{
		$this->_securityKey = $securityKey;
	}
	
	public function getScormEngineServiceUrl()
	{
		return $this->_scormEngineServiceUrl;
	}
	public function setScormEngineServiceUrl($scormEngineServiceUrl)
	{
		$this->_scormEngineServiceUrl = $scormEngineServiceUrl;
	}
}
?>