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


class Configuration{
	
	private $_appId = null;
    private $_securityKey = null;
    private $_scormEngineServiceUrl = null;
    private $_appManagerId = null;
    private $_managerSecurityKey = null;
    private $_originString = 'rusticisoftware.phplibrary.1.3.1';

    private $_proxy = null;

	public function __construct($scormEngineServiceUrl, $appId, $securityKey, $appManagerId, $managerSecurityKey, $originString) {
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

		// appManagerId
		if (isset($appManagerId)) {
			$this->setAppManagerId($appManagerId);
		} 
		// managerSecurityKey
		if (isset($managerSecurityKey)) {
			$this->setManagerSecurityKey($managerSecurityKey);
		}
		
		if (isset($originString)) {
			$this->setOriginString($originString);
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

	public function getAppManagerId()
	{
		return $this->_appManagerId;
	}
	public function setAppManagerId($appManagerId)
	{
		$this->_appManagerId = $appManagerId;
	}
	
	public function getManagerSecurityKey()
	{
		return $this->_managerSecurityKey;
	}
	public function setManagerSecurityKey($securityKey)
	{
		$this->_managerSecurityKey = $securityKey;
	}
	
	public function getScormEngineServiceUrl()
	{
		return $this->_scormEngineServiceUrl;
	}
	public function setScormEngineServiceUrl($scormEngineServiceUrl)
	{
		$this->_scormEngineServiceUrl = $scormEngineServiceUrl;
	}
	
	public function getOriginString()
	{
		return $this->_originString;
	}
	
	public function setOriginString($originString)
	{
		$this->_originString = $originString;
	}

    public function setProxy($proxy) {
        $this->_proxy = $proxy;
    }

    public function getProxy() {
        return $this->_proxy;
    }
}
?>
