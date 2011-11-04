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
require_once 'DispatchDestination.php';
require_once 'Dispatch.php';

/// <summary>
/// Client-side proxy for the "rustici.course.*" Hosted SCORM Engine web
/// service methods.  
/// </summary>
class DispatchService {
	
	private $_configuration = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
	}
	
    public function GetDestinationList($page, $tagList = null)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('page' => $page);
        if($tagList != null && count($tagList) > 0){
            $params['tags'] = implode(',',$tagList);
        }
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.dispatch.getDestinationList");
        return DispatchDestination::parseDestinationList($response);
    }

    public function CreateDestination($name, $tagList = null, $email = null)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('name' => $name);
        if($tagList != null && count($tagList) > 0){
            $params['tags'] = implode(',',$tagList);
        }
        if($email != null){
            $params['email'] = $email;
        }
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.dispatch.createDestination");

		$xml = simplexml_load_string($response);
        return $xml->destinationId;
    }

    public function DeleteDestination($destinationId)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('destinationid' => $destinationId);
		$request->setMethodParams($params);
        $request->CallService("rustici.dispatch.deleteDestination");
    }

    public function GetDestinationInfo($destinationId)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('destinationid' => $destinationId);
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.dispatch.getDestinationInfo");
        $xml = simplexml_load_string($response);
        return new DispatchDestination($xml->dispatchDestination);
    }

    public function UpdateDestination($destinationId, $name = null, $tagList = null)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('destinationid' => $destinationId);
        if($name != null) {
            $params['name'] = $name;
        }
        if($tagList != null){
            $params['tags'] = implode(',',$tagList);
        }
		$request->setMethodParams($params);
        $request->CallService("rustici.dispatch.updateDestination");
    }


    public function CreateDispatch($destinationId, $courseId, $tagList = null, $email = null)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('destinationid' => $destinationId);
        $params['courseid'] = $courseId;
        if($tagList != null){
            $params['tags'] = implode(',',$tagList);
        }
        if($email != null){
            $params['email'] = $email;
        }
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.dispatch.createDispatch");
        $xml = simplexml_load_string($response);
        return $xml->dispatchId;
    }

    public function GetDispatchInfo($dispatchId)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array('dispatchid' => $dispatchId);
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.dispatch.getDispatchInfo");
        $xml = simplexml_load_string($response);
        return new Dispatch($xml->dispatch);
    }

    public function DeleteDispatches($destinationId = null, $courseId = null, $dispatchId = null, $tagList = null)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array();
        if($destinationId != null){
            $params['destinationid'] = $destinationId;
        }
        if($courseId != null){
            $params['courseid'] = $courseId;
        }
        if($dispatchId != null){
            $params['dispatchid'] = $dispatchId;
        }
        if($tagList != null && count($tagList) > 0){
            $params['tags'] = implode(',',$tagList);
        }
		$request->setMethodParams($params);
        $request->CallService("rustici.dispatch.deleteDispatches");
    }

    public function GetDispatchList($page, $destinationId = null, $courseId = null, $dispatchId = null, $tagList = null)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array("page" => $page);
        if($destinationId != null){
            $params['destinationid'] = $destinationId;
        }
        if($courseId != null){
            $params['courseid'] = $courseId;
        }
        if($tagList != null && count($tagList) > 0){
            $params['tags'] = implode(',',$tagList);
        }
		$request->setMethodParams($params);
        $response = $request->CallService("rustici.dispatch.getDispatchList");
        return Dispatch::parseDispatchList($response);
    }

    public function UpdateDispatches($destinationId = null, $courseId = null, $dispatchId = null, $tagList = null, $enabled = -1, $tagsToAdd = null, $tagsToRemove = null)
    {
        echo "enabled = $enabled\n";
        $request = new ServiceRequest($this->_configuration);
        $params = array();
        if($destinationId != null){
            $params['destinationid'] = $destinationId;
        }
        if($courseId != null){
            $params['courseid'] = $courseId;
        }
        if($dispatchId != null){
            $params['dispatchid'] = $dispatchId;
        }
        if($tagList != null && count($tagList) > 0){
            $params['tags'] = implode(',',$tagList);
        }
        if($enabled != -1){
            $params['enabled'] = ($enabled ? "true" : "false");
        }
        if($tagsToAdd != null && count($tagsToAdd) > 0){
            $params['addtags'] = implode(',',$tagsToAdd);
        }
        if($tagsToRemove != null && count($tagsToRemove) > 0){
            $params['removetags'] = implode(',',$tagsToRemove);
        }
		$request->setMethodParams($params);
        $request->CallService("rustici.dispatch.updateDispatches");
    }

    public function GetDispatchDownloadUrl($destinationId = null, $courseId = null, $dispatchId = null, $tagList = null, $cssUrl = null)
    {
        $request = new ServiceRequest($this->_configuration);
        $params = array();
        if($destinationId != null){
            $params['destinationid'] = $destinationId;
        }
        if($courseId != null){
            $params['courseid'] = $courseId;
        }
        if($dispatchId != null){
            $params['dispatchid'] = $dispatchId;
        }
        if($tagList != null && count($tagList) > 0){
            $params['tags'] = implode(',',$tagList);
        }
        if($cssUrl != null){
            $params['cssurl'] = $cssUrl;
        }
		$request->setMethodParams($params);
        return $request->ConstructUrl("rustici.dispatch.downloadDispatches");
    }

}
