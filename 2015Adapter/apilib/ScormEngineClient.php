<?php
namespace RusticiSoftware\Engine\Client
{
    require_once(dirname(__FILE__) . '/generated/Configuration.php');
    require_once(dirname(__FILE__) . '/generated/Courses.php');
    require_once(dirname(__FILE__) . '/generated/Ping.php');
    require_once(dirname(__FILE__) . '/generated/Registrations.php');

    use RusticiSoftware\Engine\Client as client;

    class ScormEngineClient
    {
        private $baseUri;
        private $authenticator;
        private $tenant;
        private $configuration;

        public function __construct($baseUri, $apiUsername, $apiPassword, $tenant, $configuration="")
        {
            $this->baseUri = $baseUri;
            $this->authenticator = new client\HttpBasicAuthenticator($apiUsername, $apiPassword);
            $this->tenant = $tenant;
            $this->configuration = $configuration;
        }

	    public function GetConfigurationApiClient()
        {
            return new client\Configuration($this->baseUri,
                                            $this->authenticator,
                                            $this->tenant,
                                            $this->configuration);
        }

        public function GetCoursesApiClient()
        {
            return new client\Courses($this->baseUri,
                $this->authenticator,
                $this->tenant,
                $this->configuration);
        }

        public function GetPingApiClient()
        {
            return new client\Ping($this->baseUri,
                $this->authenticator,
                $this->tenant,
                $this->configuration);
        }

        public function GetRegistrationsApiClient()
        {
            return new client\Registrations($this->baseUri,
                $this->authenticator,
                $this->tenant,
                $this->configuration);
        }
    }
}
?>