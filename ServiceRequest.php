<?php

require_once 'Configuration.php';

class ServiceRequest{
	
	/**
     * Number of seconds to wait while connecting to the server.
     */
    const TIMEOUT_CONNECTION = 30;
    /**
     * Total number of seconds to wait for a request.
     */
    const TIMEOUT_TOTAL = 500;
	
	private $_configuration = null;
	private $_methodParams = array();
	private $_fileToPost = null;
	
	public function __construct($configuration) {
		$this->_configuration = $configuration;
		//echo $this->_configuration->getAppId();
	}
	
	public function setMethodParams($paramsArray)
	{
		$this->_methodParams = $paramsArray;	
	}
	
	public function setFileToPost($fileName)
	{
		$this->_fileToPost = $fileName;
	}
	
	public function CallService($methodName, $serviceUrl = null)
	{
		
		$postParams = null;
		if(isset($this->_fileToPost))
		{
			//echo '_fileToPost='.$this->_fileToPost;
			//TODO - check to see if this file exists
			$fileContents = file_get_contents($this->_fileToPost);
			$postParams = array('filedata' => "@$this->_fileToPost");
		}

        //$responseText = Encoding.GetEncoding("utf-8").GetString(responseBytes);

		$url = $this->ConstructUrl($methodName, $serviceUrl);

		//echo $url.'<br><br>';
		$responseText = $this->submitHttpPost($url,$postParams);
		//error_log($responseText);
        $response = $this->AssertNoErrorAndReturnXml($responseText);

        return $response;
	}
	
	public function ConstructUrl($methodName, $serviceUrl = null)
	{
		//error_log('serviceUrl = '.$serviceUrl);
		$parameterMap = array(	'method' => $methodName,
								'appid' => $this->_configuration->getAppId(),
								'ts' => gmdate("YmdHis")
							);
		array_merge($parameterMap,$this->_methodParams);
		foreach($this->_methodParams as $key => $value)
		{
			$parameterMap[$key] = $value;
		}
		
		if(isset($serviceUrl))
		{
			$url = $serviceUrl.'/api';
		}else{
			$url = $this->_configuration->getScormEngineServiceUrl().'/api';
		}
	
		
		$url .= '?'.$this->signParams($this->_configuration->getSecurityKey(),$parameterMap);
		
		error_log("SCORM Cloud ConstructUrl : ".$url);
		
		return $url;
	}
	
	 /// <summary>
        /// This method will evaluate the reponse string and manually validate
        /// the top-level structure.  If an err is present, this will be turned
        /// into a Service Exception.
        /// </summary>
        /// <param name="xmlString">Response from web service as xml</param>
        /// <returns>XML document from the given string, provided no service errors are present</returns>
        private static function AssertNoErrorAndReturnXml($xmlString)
        {

            $xmlDoc = simplexml_load_string($xmlString);
            $rspElements = $xmlDoc;
			error_log('stat : '.$rspElements["stat"]);
			if($rspElements["stat"]!='ok')
			{
				$errmsg = "";
				if($rspElements["stat"]=='fail')
				{
					$errmsg = "SCORM Cloud Error : ".$rspElements->err["code"]." - ".$rspElements->err["msg"];
				}else{
					$errmsg = "Invalid XML Response from web service call, expected <rsp> tag, instead received: ".$xmlString;
				}
				error_log($errmsg);
				throw new Exception($errmsg);
			}

            return $xmlString;
        }
	
	/**
     * Submit a POST request with to the specified URL with given parameters.
     *
     * @param   string $url
     * @param   array $params An optional array of parameter name/value
     *          pairs to include in the POST.
     * @param   integer $timeout The total number of seconds, including the
     *          wait for the initial connection, wait for a request to complete.
     * @return  string
     * @throws  Phlickr_ConnectionException
     * @uses    TIMEOUT_CONNECTION to determine how long to wait for a
     *          for a connection.
     * @uses    TIMEOUT_TOTAL to determine how long to wait for a request
     *          to complete.
     * @uses    set_time_limit() to ensure that PHP's script timer is five
     *          seconds longer than the sum of $timeout and TIMEOUT_CONNECTION.
     */
    static function submitHttpPost($url, $postParams = null, $timeout = self::TIMEOUT_TOTAL)
    {
		//foreach($postParams as $key => $value)
		//{
		//	echo $key.'='.$value.'<br>';
		//}
	
        $ch = curl_init();

        // set up the request
        curl_setopt($ch, CURLOPT_URL, $url);
        // make sure we submit this as a post
        curl_setopt($ch, CURLOPT_POST, true);
        if (isset($postParams)) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
        }else{
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");        	
        }
        // make sure problems are caught
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        // return the output
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // set the timeouts
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::TIMEOUT_CONNECTION);
        curl_setopt($ch, CURLOPT_TIMEOUT,$timeout);

		//set header expect empty for upload issue...
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

        // set the PHP script's timeout to be greater than CURL's
        set_time_limit(self::TIMEOUT_CONNECTION + $timeout + 5);

        $result = curl_exec($ch);
        // check for errors
        if (0 == curl_errno($ch)) {
            curl_close($ch);
            return $result;
        } else {
            //$ex = new Phlickr_ConnectionException(
            //echo 'Request failed. '.curl_error($ch);
            curl_close($ch);
            //throw $ex;
        }
    }

    /**
     * Create a signed signature of the parameters.
     *
     * Return a parameter string that can be tacked onto the end of a URL.
     * Items will be sorted and an api_sig element will be on the end.
     */
    static function signParams($secret, $params)
    {
        $signing = '';
        $values = array();
        ksort($params);

        foreach($params as $key => $value) {
            $signing .= $key . $value;
            $values[] = $key . '=' . urlencode($value);
        }
        $values[] = 'sig=' . md5($secret . $signing);

        return implode('&', $values);
    }
}

?>