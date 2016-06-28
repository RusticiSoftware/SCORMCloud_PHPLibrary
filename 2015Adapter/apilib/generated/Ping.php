<?php
namespace RusticiSoftware\Engine\Client
{
     require_once (dirname(__FILE__) . '/../includes/ClientLibraryIncludes.php');
     use RusticiSoftware\ScormContentPlayer\api\model as model;
     use RusticiSoftware\Engine\Client as client;

    /* 
     * Ping
     *
     * Engine API client for Ping resource.
     *
     */
    class Ping extends client\BaseClient
    {
        private $tenant;
        private $configuration;
        private $client;

        /**
         * Constructor for Engine API client for Ping resource.
         *
         * @param string $baseUri Base URI for the API, eg: https://hostname/ScormEngineInterface/api/v1/
         * @param IAuthenticator $authenticator Authentication to use on requests. For Basic Auth, use new HttpBasicAuthenticator(user, password).
         * @param string $tenant Tenant identifier or 'default' for single-tenant systems
         * @param string $configuration Serialized external configuration
         */
        public function __construct($baseUri, client\IAuthenticator $authenticator, $tenant="default", $configuration="")
        {
            $this->client = new client\RestClient($baseUri, $authenticator);
            $this->tenant = $tenant;
            $this->configuration = $configuration;
        }


        /**
        * getPing
        *
        * Get back a message indicating that the API is working.
        *
        *
        * @return messageSchema
        */
        public function getPing()
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/ping", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\messageSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }
    }
}
?>
