<?php
namespace RusticiSoftware\Engine\Client
{
     require_once (dirname(__FILE__) . '/../includes/ClientLibraryIncludes.php');
     use RusticiSoftware\ScormContentPlayer\api\model as model;
     use RusticiSoftware\Engine\Client as client;

    /* 
     * Configuration
     *
     * Engine API client for Configuration resource.
     *
     */
    class Configuration extends client\BaseClient
    {
        private $tenant;
        private $configuration;
        private $client;

        /**
         * Constructor for Engine API client for Configuration resource.
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
        * getConfiguration
        *
        * Returns the effective values for all configuration settings associated with the parent resource.
        *
        *
        * @return configListSchema
        */
        public function getConfiguration()
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/configuration", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\configListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * putConfigurationBySettingIdByEntitysettingSchema
        *
        * Sets the value for this configuration setting, for the resource being configured.
        *
        * @param string settingId string : id for this configuration setting
        * @param settingSchema entitysettingSchema settingSchema : The object to PUT
        *
        * @return void
        */
        public function putConfigurationBySettingIdByEntitysettingSchema( $settingId, model\settingSchema $entitysettingSchema)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/configuration/{settingId}", client\Methods::PUT, client\Formats::JSON));
            $request->addUrlSegment("settingId", $settingId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            $request->addBody($entitysettingSchema);
            $this->getResponse($this->client, $request);
        }

        /**
        * getConfigurationBySettingId
        *
        * Returns the effective value for this configuration setting for the resource being configured.
        *
        * @param string settingId string : id for this configuration setting
        *
        * @return settingSchema
        */
        public function getConfigurationBySettingId( $settingId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/configuration/{settingId}", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("settingId", $settingId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\settingSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }
    }
}
?>
