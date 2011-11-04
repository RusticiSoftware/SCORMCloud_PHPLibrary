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

class Dispatch {
    private $_id;
    private $_destinationId;
    private $_appId;
    private $_courseAppId;
    private $_courseId;
    private $_enabled;
    private $_notes;
    private $_createdBy;
    private $_createDate;
    private $_updateDate;
    private $_tags;

    public function __construct($xmlElem)
    {
		if(isset($xmlElem))
		{
	        $this->_id = (string) $xmlElem->id;
	        $this->_destinationId = (string) $xmlElem->destinationId;
	        $this->_appId = (string) $xmlElem->appId;
	        $this->_courseAppId = (string) $xmlElem->courseAppId;
	        $this->_courseId = (string) $xmlElem->courseId;
	        $this->_enabled = (string)$xmlElem->enabled;
	        $this->_notes = (string) $xmlElem->notes;
	        $this->_createdBy = (string) $xmlElem->createdBy;
	        $this->_createDate = (string) $xmlElem->createDate;
	        $this->_updateDate = (string) $xmlElem->updateDate;
            $this->_tags = array();
            foreach ($xmlElem->tags->tag as $tag){
	            $this->_tags[] = (string)$tag;
            }
		}
    }
    
    public static function parseDispatchList($xmlString)
    {
        #echo $xmlString;
        
		$xml = simplexml_load_string($xmlString);
		if (false === $xml) {
            //throw new ScormEngine_XmlParseException('Could not parse XML.', $courseDataElement);
        }
        
		$allResults = array();

        foreach ($xml->dispatches->dispatch as $dispatchElem)
        {
            $allResults[] = new Dispatch($dispatchElem);
        }

        return $allResults;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getDestinationId()
    {
        return $this->_destinationId;
    }

    public function getAppId()
    {
        return $this->_appId;
    }

    public function getCourseAppId()
    {
        return $this->_courseAppId;
    }

    public function getCourseId()
    {
        return $this->_courseId;
    }

    public function getEnabled()
    {
        return $this->_enabled;
    }

    public function getNotes()
    {
        return $this->_notes;
    }

    public function getCreatedBy()
    {
        return $this->_createdBy;
    }

    public function getCreateDate()
    {
        return $this->_createDate;
    }

    public function getUpdateDate()
    {
        return $this->_updateDate;
    }

    public function getTags()
    {
        return $this->_tags;
    }

}
?>
