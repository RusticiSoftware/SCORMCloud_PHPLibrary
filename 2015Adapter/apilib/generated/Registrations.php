<?php
namespace RusticiSoftware\Engine\Client
{
     require_once (dirname(__FILE__) . '/../includes/ClientLibraryIncludes.php');
     use RusticiSoftware\ScormContentPlayer\api\model as model;
     use RusticiSoftware\Engine\Client as client;

    /* 
     * Registrations
     *
     * Engine API client for Registrations resource.
     *
     */
    class Registrations extends client\BaseClient
    {
        private $tenant;
        private $configuration;
        private $client;

        /**
         * Constructor for Engine API client for Registrations resource.
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
        * postRegistrationsByEntityregistrationSchema
        *
        * Create a registration. The application/json format should be used, the application/x-www-form-urlencoded is available for compatibiliy with older systems.
        *
        * @param registrationSchema entityregistrationSchema registrationSchema : The object to POST
        *
        * @return void
        */
        public function postRegistrationsByEntityregistrationSchema(model\registrationSchema $entityregistrationSchema)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations", client\Methods::POST, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            $request->addBody($entityregistrationSchema);
            $this->getResponse($this->client, $request);
        }

        /**
        * postRegistrationsByRegistrationByPackageIdByForCredit
        *
        * Create a registration. The application/json format should be used, the application/x-www-form-urlencoded is available for compatibiliy with older systems.
        *
        * @param string registration string : Id for the registration to be created.
        * @param string packageId string : Id of the package (course) for which the registration should be created.
        * @param bool forCredit bool : Indicates whether the course is being taken for credit.
        *
        * @return void
        */
        public function postRegistrationsByRegistrationByPackageIdByForCredit( $registration,  $packageId,  $forCredit)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations", client\Methods::POST, client\Formats::JSON));
            $request->setFormat(client\Formats::FORM_URL);
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration)->addParameter("registration", $registration, client\ParameterType::GetOrPost)->addParameter("packageId", $packageId, client\ParameterType::GetOrPost)->addParameter("forCredit", $forCredit, client\ParameterType::GetOrPost);
            $this->getResponse($this->client, $request);
        }

        /**
        * postRegistrationsByRegistrationByPackageId
        *
        * Create a registration. The application/json format should be used, the application/x-www-form-urlencoded is available for compatibiliy with older systems.
        *
        * @param string registration string : Id for the registration to be created.
        * @param string packageId string : Id of the package (course) for which the registration should be created.
        *
        * @return void
        */
        public function postRegistrationsByRegistrationByPackageId( $registration,  $packageId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations", client\Methods::POST, client\Formats::JSON));
            $request->setFormat(client\Formats::FORM_URL);
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration)->addParameter("registration", $registration, client\ParameterType::GetOrPost)->addParameter("packageId", $packageId, client\ParameterType::GetOrPost);
            $this->getResponse($this->client, $request);
        }

        /**
        * getRegistrationsByCourseIdByLearnerIdBySinceByMore
        *
        * Gets a list of registrations including a summary of the status of each registration. Note the "since" parameter exists to allow retreiving only registrations that have changed.
        *
        * @param string courseId string : Only registrations for the specified course id will be included.
        * @param string learnerId string : Only registrations for the specified learner id will be included.
        * @param string since string : Only registrations updated since the specified ISO 8601 TimeStamp (inclusive) are included. If a time zone is not specified, the server's time zone will be used.
        * @param string more string : Value for this parameter will be provided in the 'more' property of registrations lists, where needed. An opaque value, construction and parsing may change without notice.
        *
        * @return registrationListSchema
        */
        public function getRegistrationsByCourseIdByLearnerIdBySinceByMore( $courseId,  $learnerId,  $since,  $more)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("courseId", $courseId)->addQueryParameter("learnerId", $learnerId)->addQueryParameter("configuration", $this->configuration)->addQueryParameter("since", $since)->addQueryParameter("more", $more);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\registrationListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrations
        *
        * Gets a list of registrations including a summary of the status of each registration. Note the "since" parameter exists to allow retreiving only registrations that have changed.
        *
        *
        * @return registrationListSchema
        */
        public function getRegistrations()
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\registrationListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationsCountByCourseId
        *
        * Gets the number of registrations, optionally for the specified course ID
        *
        * @param string courseId string : Only registrations for the specified course id will be included.
        *
        * @return integerResultSchema
        */
        public function getRegistrationsCountByCourseId( $courseId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/count", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("courseId", $courseId)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\integerResultSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationsCount
        *
        * Gets the number of registrations, optionally for the specified course ID
        *
        *
        * @return integerResultSchema
        */
        public function getRegistrationsCount()
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/count", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\integerResultSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * deleteRegistrationByRegistrationId
        *
        * Delete the registration
        * with registrationId =
        * {registrationId}
        *
        * @param string registrationId string : id for this registration
        *
        * @return void
        */
        public function deleteRegistrationByRegistrationId( $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}", client\Methods::DELETE, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            $this->getResponse($this->client, $request);
        }

        /**
        * getRegistrationByRegistrationId
        *
        * Does this registration exist?
        *
        * @param string registrationId string : id for this registration
        *
        * @return minimalRegistrationSummarySchema
        */
        public function getRegistrationByRegistrationId( $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\minimalRegistrationSummarySchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationInstancesByRegistrationIdBySinceByMore
        *
        * Get all the instances of this the registration specified by the registration ID
        *
        * @param string registrationId string : id for this registration
        * @param string since string : Only instances updated since the specified ISO 8601 TimeStamp (inclusive) are included. If a time zone is not specified, the server's time zone will be used.
        * @param string more string : Value for this parameter will be provided in the 'more' property of instances lists, where needed. An opaque value, construction and parsing may change without notice.
        *
        * @return registrationListSchema
        */
        public function getRegistrationInstancesByRegistrationIdBySinceByMore( $registrationId,  $since,  $more)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/instances", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration)->addQueryParameter("since", $since)->addQueryParameter("more", $more);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\registrationListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationInstancesByRegistrationId
        *
        * Get all the instances of this the registration specified by the registration ID
        *
        * @param string registrationId string : id for this registration
        *
        * @return registrationListSchema
        */
        public function getRegistrationInstancesByRegistrationId( $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/instances", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\registrationListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationConfigurationByRegistrationIdByInstance
        *
        * Returns the effective values for all configuration settings associated with the parent resource.
        *
        * @param string registrationId string : id for this registration
        * @param long instance long : The instance of this registration to use. If not provided, the latest instance will be used. The External ID instance property should not be set.
        *
        * @return configListSchema
        */
        public function getRegistrationConfigurationByRegistrationIdByInstance( $registrationId,  $instance)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/configuration", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("instance", $instance)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\configListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationConfigurationByRegistrationId
        *
        * Returns the effective values for all configuration settings associated with the parent resource.
        *
        * @param string registrationId string : id for this registration
        *
        * @return configListSchema
        */
        public function getRegistrationConfigurationByRegistrationId( $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/configuration", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\configListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * putRegistrationConfigurationBySettingIdByRegistrationIdByInstanceByEntitysettingSchema
        *
        * Sets the value for this configuration setting, for the resource being configured.
        *
        * @param string settingId string : id for this configuration setting
        * @param string registrationId string : 
        * @param long instance long : The instance of this registration to use. If not provided, the latest instance will be used. The External ID instance property should not be set.
        * @param settingSchema entitysettingSchema settingSchema : The object to PUT
        *
        * @return void
        */
        public function putRegistrationConfigurationBySettingIdByRegistrationIdByInstanceByEntitysettingSchema( $settingId,  $registrationId,  $instance, model\settingSchema $entitysettingSchema)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/configuration/{settingId}", client\Methods::PUT, client\Formats::JSON));
            $request->addUrlSegment("settingId", $settingId)->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("instance", $instance)->addQueryParameter("configuration", $this->configuration);
            $request->addBody($entitysettingSchema);
            $this->getResponse($this->client, $request);
        }

        /**
        * putRegistrationConfigurationBySettingIdByRegistrationIdByEntitysettingSchema
        *
        * Sets the value for this configuration setting, for the resource being configured.
        *
        * @param string settingId string : id for this configuration setting
        * @param string registrationId string : 
        * @param settingSchema entitysettingSchema settingSchema : The object to PUT
        *
        * @return void
        */
        public function putRegistrationConfigurationBySettingIdByRegistrationIdByEntitysettingSchema( $settingId,  $registrationId, model\settingSchema $entitysettingSchema)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/configuration/{settingId}", client\Methods::PUT, client\Formats::JSON));
            $request->addUrlSegment("settingId", $settingId)->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            $request->addBody($entitysettingSchema);
            $this->getResponse($this->client, $request);
        }

        /**
        * getRegistrationConfigurationBySettingIdByRegistrationIdByInstance
        *
        * Returns the effective value for this configuration setting for the resource being configured.
        *
        * @param string settingId string : id for this configuration setting
        * @param string registrationId string : 
        * @param long instance long : The instance of this registration to use. If not provided, the latest instance will be used. The External ID instance property should not be set.
        *
        * @return settingSchema
        */
        public function getRegistrationConfigurationBySettingIdByRegistrationIdByInstance( $settingId,  $registrationId,  $instance)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/configuration/{settingId}", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("settingId", $settingId)->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("instance", $instance)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\settingSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationConfigurationBySettingIdByRegistrationId
        *
        * Returns the effective value for this configuration setting for the resource being configured.
        *
        * @param string settingId string : id for this configuration setting
        * @param string registrationId string : 
        *
        * @return settingSchema
        */
        public function getRegistrationConfigurationBySettingIdByRegistrationId( $settingId,  $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/configuration/{settingId}", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("settingId", $settingId)->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\settingSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationXapiRegistrationIdByRegistrationIdByInstance
        *
        * Returns xAPI registration ID associated with this registration
        *
        * @param string registrationId string : id for this registration
        * @param long instance long : The instance of this registration to get the xAPI registration ID for. If not provided, the latest instance will be used. The External ID instance property should not be set.
        *
        * @return idSchema
        */
        public function getRegistrationXapiRegistrationIdByRegistrationIdByInstance( $registrationId,  $instance)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/xapiRegistrationId", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("instance", $instance)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\idSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationXapiRegistrationIdByRegistrationId
        *
        * Returns xAPI registration ID associated with this registration
        *
        * @param string registrationId string : id for this registration
        *
        * @return idSchema
        */
        public function getRegistrationXapiRegistrationIdByRegistrationId( $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/xapiRegistrationId", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\idSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationLaunchLinkByRegistrationIdByExpiryByForceReviewByStartScoByRedirectOnExitUrl
        *
        * Returns the link to use to launch this registration
        *
        * @param string registrationId string : id for this registration
        * @param long expiry long : Number of seconds from now this link will expire in. Use 0 for no expiration.
        * @param bool forceReview bool : Launch in review mode.
        * @param string startSco string : For SCORM, SCO identifier to override launch, overriding the normal sequencing.
        * @param string redirectOnExitUrl string : The URL the application should redirect to when the learner exits a course. If not specified, configured value will be used.
        *
        * @return launchLinkSchema
        */
        public function getRegistrationLaunchLinkByRegistrationIdByExpiryByForceReviewByStartScoByRedirectOnExitUrl( $registrationId,  $expiry,  $forceReview,  $startSco,  $redirectOnExitUrl)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/launchLink", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration)->addQueryParameter("expiry", $expiry)->addQueryParameter("forceReview", $forceReview)->addQueryParameter("startSco", $startSco)->addQueryParameter("redirectOnExitUrl", $redirectOnExitUrl);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\launchLinkSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationLaunchLinkByRegistrationId
        *
        * Returns the link to use to launch this registration
        *
        * @param string registrationId string : id for this registration
        *
        * @return launchLinkSchema
        */
        public function getRegistrationLaunchLinkByRegistrationId( $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/launchLink", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\launchLinkSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationLastInstanceByRegistrationId
        *
        * gets the last instance ID that exists for this registration
        *
        * @param string registrationId string : id for this registration
        *
        * @return integerResultSchema
        */
        public function getRegistrationLastInstanceByRegistrationId( $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/lastInstance", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\integerResultSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * deleteRegistrationProgressByRegistrationId
        *
        * delete registration progress (clear registration)
        *
        * @param string registrationId string : id for this registration
        *
        * @return void
        */
        public function deleteRegistrationProgressByRegistrationId( $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/progress", client\Methods::DELETE, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            $this->getResponse($this->client, $request);
        }

        /**
        * getRegistrationProgressByRegistrationIdByInstance
        *
        * Get registration summary
        *
        * @param string registrationId string : id for this registration
        * @param long instance long : The instance of this registration to get progress for. If not provided, the latest instance will be used. The External ID instance property should not be set.
        *
        * @return registrationSummarySchema
        */
        public function getRegistrationProgressByRegistrationIdByInstance( $registrationId,  $instance)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/progress", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("instance", $instance)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\registrationSummarySchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationProgressByRegistrationId
        *
        * Get registration summary
        *
        * @param string registrationId string : id for this registration
        *
        * @return registrationSummarySchema
        */
        public function getRegistrationProgressByRegistrationId( $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/progress", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\registrationSummarySchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationProgressDetailByRegistrationIdByInstance
        *
        * Get detailed registration progress. Note: the data returned is the same as for /progress, except that 'activityDetails' is populated where applicable
        *
        * @param string registrationId string : 
        * @param long instance long : The instance of this registration to get progress for. If not provided, the latest instance will be used. The External ID instance property should not be set.
        *
        * @return registrationSummarySchema
        */
        public function getRegistrationProgressDetailByRegistrationIdByInstance( $registrationId,  $instance)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/progress/detail", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("instance", $instance)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\registrationSummarySchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getRegistrationProgressDetailByRegistrationId
        *
        * Get detailed registration progress. Note: the data returned is the same as for /progress, except that 'activityDetails' is populated where applicable
        *
        * @param string registrationId string : 
        *
        * @return registrationSummarySchema
        */
        public function getRegistrationProgressDetailByRegistrationId( $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/progress/detail", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\registrationSummarySchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * deleteRegistrationGlobalDataByRegistrationId
        *
        * delete global data associated with this registration
        *
        * @param string registrationId string : id for this registration
        *
        * @return void
        */
        public function deleteRegistrationGlobalDataByRegistrationId( $registrationId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/registrations/{registrationId}/globalData", client\Methods::DELETE, client\Formats::JSON));
            $request->addUrlSegment("registrationId", $registrationId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            $this->getResponse($this->client, $request);
        }
    }
}
?>
