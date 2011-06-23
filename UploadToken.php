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


/// <summary>
/// Client-side proxy for the "rustici.course.*" Hosted SCORM Engine web
/// service methods.  
/// </summary>
class UploadToken{
	
	private $_server;
    private $_tokenId;

	/// <summary>
    /// Purpose of this class is to map the return xml from the course listing
    /// web service into an object.  This is the main constructor.
    /// </summary>
    /// <param name="courseDataElement"></param>
    public function __construct($tokenData)
    {
		$xml = simplexml_load_string($tokenData);
		if (false === $xml) {
            //throw new ScormEngine_XmlParseException('Could not parse XML.', $courseDataElement);
        }
		if(isset($xml))
		{
	        $this->_server = $xml->token->server;
	        $this->_tokenId = $xml->token->id;
		}
    }
	
	/// <summary>
    /// Gets the Server
    /// </summary>
    public function getServer()
    {
        return $this->_server;
    }

    /// <summary>
    /// Gets the TokenId
    /// </summary>
    public function getTokenId()
    {
        return $this->_tokenId;
    }
	
}

?>
