<?php
	namespace RusticiSoftware\Engine\Client
	{
		
		interface IAuthenticator
		{
			public function getUsername();
			public function getPassword();
		}
		

		class HttpBasicAuthenticator implements IAuthenticator
		{
			private $username;
			private $password;

			//$uri: pass in the enpoint 
			//$verb: POST, GET, PUT, DELETE.
			//$format: json
			//
			public function __construct($username, $password)
			{
				$this->username =  $username;
				$this->password = $password;
			}

			public function getUsername()
			{
				return $this->username;
			}

			public function getPassword()
			{
				return $this->password;
			}
	    }
	}
?>