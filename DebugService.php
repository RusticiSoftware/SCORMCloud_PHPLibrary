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
	
	public function CloudPing($throw = false)
    {
		write_log('rustici.debug.ping being called...');
        $request = new ServiceRequest($this->_configuration);
        try {
            $response = $request->CallService("rustici.debug.ping");
            write_log('rustici.debug.ping returned : '.$response);
        } catch (Exception $e) {
            write_log('rustici.debug.ping threw Exception: '.$e->getMessage());
            return false;
        }
        
		$xml = simplexml_load_string($response);
		return ($xml['stat'] == 'ok');
    }

	public function CloudAuthPing($throw = false)
    {
		write_log('rustici.debug.authPing being called...');
        $request = new ServiceRequest($this->_configuration);
        try {
            $response = $request->CallService("rustici.debug.authPing");
            write_log('rustici.debug.authPing returned : '.$response);
        } catch (Exception $e) {
            write_log('rustici.debug.authPing threw Exception: '.$e->getMessage());
            return false;
        }
        
		$xml = simplexml_load_string($response);
		return ($xml['stat'] == 'ok');
    }

    
}

?>
