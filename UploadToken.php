<?php

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