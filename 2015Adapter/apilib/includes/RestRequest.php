<?php
	namespace RusticiSoftware\Engine\Client
	{
		use RusticiSoftware\ScormContentPlayer\api\model as model;
     	use RusticiSoftware\Engine\Client as client;
		
		interface IRestRequest
		{
			public function getUri();
			public function getVerb();
			public function getFormat();
			public function setFormat($format);
			public function getBody();
			public function getFile();
			//public function getJsonSerializer();

			public function addUrlSegment($segmentName, $segmentValue);
			public function addBody($body);
			public function addFile(model\multiPart $file);
			public function addQueryParameter($parameterName, $parameterValue);
			public function addParameter($parameterName, $parameterValue, $parameterType);
		}
		

		class RestRequest implements IRestRequest
		{
			private $format;
			private $jsonSerializer;
			private $verb;
			private $uri;
			private $body;
			private $file;
			private $formData;

			//$uri: pass in the enpoint 
			//$verb: POST, GET, PUT, DELETE.
			//$format: json
			public function __construct($uri, $verb, $format)
			{
				$this->uri =  $uri;
				$this->verb = $verb;
				$this->format = $format;
				$this->formData = array();
			}

			public function getUri()
			{
				return $this->uri;
			}

			public function getVerb()
			{
				return $this->verb;
			}

			public function getFormat()
			{
				return $this->format;
			}

			public function setFormat($format)
			{
				return $this->format = $format;
			}

			public function getBody()
			{
				if($this->format == client\Formats::FORM_URL)
				{
					return http_build_query($this->formData);
				}
				else
				{
					return $this->body;					
				}
			}

			public function getFile()
			{
				return $this->file;
			}

			public function addUrlSegment($segmentName, $segmentValue)
			{
				$this->uri = str_replace("{" . $segmentName . "}", $segmentValue, $this->uri);
				return $this;
			}

			public function addQueryParameter($parameterName, $parameterValue)
			{
				if(is_bool($parameterValue))
				{
					$parameterValue = $this->boolToString($parameterValue);
				}

				if (strpos($this->uri, '?') !== false) 
				{
	    			$this->uri = $this->uri . '&' . urlencode($parameterName) . '=' . urlencode(strval($parameterValue));
				}
				else
				{
					$this->uri = $this->uri . '?' . urlencode($parameterName) . '=' . urlencode(strval($parameterValue));
				}		
				return $this;
			}

			public function addBody($body)
			{

				$json = json_encode($body);

				//strip out any null values.
				$json = preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', $json);

				//add the null-stripped json to the request body.
				$this->body = $json;
				return $this;
			}

			public function addParameter($parameterName, $parameterValue, $parameterType)
			{
				if($this->getformat() == client\Formats::FORM_URL)
				{
					$this->formData[$parameterName]=$parameterValue;
				}
				else
				{
					$this->AddQueryParameter($parameterName, $parameterValue);
				}
				return $this;
			}

			public function addFile(model\multiPart $file)
			{
				$this->file = $file;
			}

			function boolToString($boolVal = false)
			{
  				return ($boolVal ? 'true' : 'false');
			}

	    }
	}
?>