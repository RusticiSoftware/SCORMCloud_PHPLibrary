<?php
namespace RusticiSoftware\Engine\Client
{

	require_once (dirname(__FILE__) . '/Authenticator.php');
	
	class RestClient
	{
		private $baseUri;
		private $authenticator;

		//$uri: pass in the enpoint 
		//$verb: POST, GET, PUT, DELETE.
		//$format: json
		//
		public function __construct($baseUri, IAuthenticator $authenticator)
		{
			$this->baseUri =  $baseUri;
			$this->authenticator = $authenticator;
		}

		public function getBaseUri()
		{
			return $this->baseUri;
		}

		public function getAuthenticator(){
			return $this->authenticator;
		}

    }
}
?>