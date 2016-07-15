<?php
namespace RusticiSoftware\Engine\Client
{
     require_once (dirname(__FILE__) . '/../includes/ClientLibraryIncludes.php');
     use RusticiSoftware\ScormContentPlayer\api\model as model;
     use RusticiSoftware\Engine\Client as client;

    /* 
     * Courses
     *
     * Engine API client for Courses resource.
     *
     */
    class Courses extends client\BaseClient
    {
        private $tenant;
        private $configuration;
        private $client;

        /**
         * Constructor for Engine API client for Courses resource.
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
        * getCoursesBySinceByMore
        *
        * Get the list of courses
        *
        * @param string since string : Only courses updated since the specified ISO 8601 TimeStamp (inclusive) are included. If a time zone is not specified, the server's time zone will be used.
        * @param string more string : Value for this parameter will be provided in the 'more' property of courses lists, where needed. An opaque value, construction and parsing may change without notice.
        *
        * @return courseListSchema
        */
        public function getCoursesBySinceByMore( $since,  $more)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration)->addQueryParameter("since", $since)->addQueryParameter("more", $more);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\courseListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCourses
        *
        * Get the list of courses
        *
        *
        * @return courseListSchema
        */
        public function getCourses()
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\courseListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * deleteCourseByCourseIdByVersion
        *
        * Delete the course
        * with courseId =
        * {courseId}
        *
        * @param string courseId string : Serialized course ID
        * @param long version long : The version of this course to use. If not provided, the latest version will be used. The External ID version property should not be set.
        *
        * @return void
        */
        public function deleteCourseByCourseIdByVersion( $courseId,  $version)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}", client\Methods::DELETE, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration)->addQueryParameter("version", $version);
            $this->getResponse($this->client, $request);
        }

        /**
        * deleteCourseByCourseId
        *
        * Delete the course
        * with courseId =
        * {courseId}
        *
        * @param string courseId string : Serialized course ID
        *
        * @return void
        */
        public function deleteCourseByCourseId( $courseId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}", client\Methods::DELETE, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            $this->getResponse($this->client, $request);
        }

        /**
        * getCourseByCourseIdBySinceByMore
        *
        * Get courses based on courseId
        *
        * @param string courseId string : Serialized course ID
        * @param string since string : Only courses updated since the specified ISO 8601 TimeStamp (inclusive) are included. If a time zone is not specified, the server's time zone will be used.
        * @param string more string : Value for this parameter will be provided in the 'more' property of courses lists, where needed. An opaque value, construction and parsing may change without notice.
        *
        * @return courseListSchema
        */
        public function getCourseByCourseIdBySinceByMore( $courseId,  $since,  $more)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration)->addQueryParameter("since", $since)->addQueryParameter("more", $more);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\courseListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCourseByCourseId
        *
        * Get courses based on courseId
        *
        * @param string courseId string : Serialized course ID
        *
        * @return courseListSchema
        */
        public function getCourseByCourseId( $courseId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\courseListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCourseLastVersionByCourseId
        *
        * gets the last version ID that exists for this course
        *
        * @param string courseId string : Serialized course ID
        *
        * @return integerResultSchema
        */
        public function getCourseLastVersionByCourseId( $courseId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/lastVersion", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\integerResultSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCourseTitleByCourseId
        *
        * get the course title
        *
        * @param string courseId string : Serialized course ID
        *
        * @return titleSchema
        */
        public function getCourseTitleByCourseId( $courseId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/title", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\titleSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCoursePreviewByCourseIdByExpiryByForceReviewByStartScoByRedirectOnExitUrl
        *
        * Returns the launch link to use to preview this course
        *
        * @param string courseId string : Serialized course ID
        * @param long expiry long : Number of seconds from now this link will expire in. Use 0 for no expiration.
        * @param bool forceReview bool : Launch in review mode.
        * @param string startSco string : For SCORM, SCO identifier to override launch, overriding the normal sequencing.
        * @param string redirectOnExitUrl string : The URL the application should redirect to when the learner exits a course. If not specified, configured value will be used.
        *
        * @return launchLinkSchema
        */
        public function getCoursePreviewByCourseIdByExpiryByForceReviewByStartScoByRedirectOnExitUrl( $courseId,  $expiry,  $forceReview,  $startSco,  $redirectOnExitUrl)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/preview", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration)->addQueryParameter("expiry", $expiry)->addQueryParameter("forceReview", $forceReview)->addQueryParameter("startSco", $startSco)->addQueryParameter("redirectOnExitUrl", $redirectOnExitUrl);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\launchLinkSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCoursePreviewByCourseId
        *
        * Returns the launch link to use to preview this course
        *
        * @param string courseId string : Serialized course ID
        *
        * @return launchLinkSchema
        */
        public function getCoursePreviewByCourseId( $courseId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/preview", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\launchLinkSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCourseXapiActivityIdByCourseIdByVersion
        *
        * Returns xAPI activity ID associated with this course
        *
        * @param string courseId string : Serialized course ID
        * @param long version long : The version of this course to use. If not provided, the latest version will be used. The External ID version property should not be set.
        *
        * @return idSchema
        */
        public function getCourseXapiActivityIdByCourseIdByVersion( $courseId,  $version)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/xapiActivityId", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration)->addQueryParameter("version", $version);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\idSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCourseXapiActivityIdByCourseId
        *
        * Returns xAPI activity ID associated with this course
        *
        * @param string courseId string : Serialized course ID
        *
        * @return idSchema
        */
        public function getCourseXapiActivityIdByCourseId( $courseId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/xapiActivityId", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\idSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCourseConfigurationByCourseIdByVersion
        *
        * Returns the effective values for all configuration settings associated with the parent resource.
        *
        * @param string courseId string : Serialized course ID
        * @param long version long : The version of this course to use. If not provided, the latest version will be used. The External ID version property should not be set.
        *
        * @return configListSchema
        */
        public function getCourseConfigurationByCourseIdByVersion( $courseId,  $version)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/configuration", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("version", $version)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\configListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCourseConfigurationByCourseId
        *
        * Returns the effective values for all configuration settings associated with the parent resource.
        *
        * @param string courseId string : Serialized course ID
        *
        * @return configListSchema
        */
        public function getCourseConfigurationByCourseId( $courseId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/configuration", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\configListSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * putCourseConfigurationBySettingIdByCourseIdByEntitysettingSchema
        *
        * Sets the value for this configuration setting, for the resource being configured.
        *
        * @param string settingId string : id for this configuration setting
        * @param string courseId string : 
        * @param settingSchema entitysettingSchema settingSchema : The object to PUT
        *
        * @return void
        */
        public function putCourseConfigurationBySettingIdByCourseIdByEntitysettingSchema( $settingId,  $courseId, model\settingSchema $entitysettingSchema)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/configuration/{settingId}", client\Methods::PUT, client\Formats::JSON));
            $request->addUrlSegment("settingId", $settingId)->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            $request->addBody($entitysettingSchema);
            $this->getResponse($this->client, $request);
        }

        /**
        * getCourseConfigurationBySettingIdByCourseIdByVersion
        *
        * Returns the effective value for this configuration setting for the resource being configured.
        *
        * @param string settingId string : id for this configuration setting
        * @param string courseId string : 
        * @param long version long : The version of this course to use. If not provided, the latest version will be used. The External ID version property should not be set.
        *
        * @return settingSchema
        */
        public function getCourseConfigurationBySettingIdByCourseIdByVersion( $settingId,  $courseId,  $version)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/configuration/{settingId}", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("settingId", $settingId)->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("version", $version)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\settingSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCourseConfigurationBySettingIdByCourseId
        *
        * Returns the effective value for this configuration setting for the resource being configured.
        *
        * @param string settingId string : id for this configuration setting
        * @param string courseId string : 
        *
        * @return settingSchema
        */
        public function getCourseConfigurationBySettingIdByCourseId( $settingId,  $courseId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/configuration/{settingId}", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("settingId", $settingId)->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\settingSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCoursePackagePropertiesLinkByCourseIdByCssUrl
        *
        * Returns the link to use to access the package properties editor for the course specified by courseId. A token will be used as part of the URL in order to secure the request to the package properties editor link generated.
        *
        * @param string courseId string : Serialized course ID
        * @param string cssUrl string : URL to the stylesheet to use for the properties page
        *
        * @return linkSchema
        */
        public function getCoursePackagePropertiesLinkByCourseIdByCssUrl( $courseId,  $cssUrl)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/packagePropertiesLink", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("cssUrl", $cssUrl)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\linkSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCoursePackagePropertiesLinkByCourseId
        *
        * Returns the link to use to access the package properties editor for the course specified by courseId. A token will be used as part of the URL in order to secure the request to the package properties editor link generated.
        *
        * @param string courseId string : Serialized course ID
        *
        * @return linkSchema
        */
        public function getCoursePackagePropertiesLinkByCourseId( $courseId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/{courseId}/packagePropertiesLink", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("courseId", $courseId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\linkSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * postCoursesImportJobsByCourseByMayCreateNewVersionByEntitymultiPart
        *
        * Either the actual contents of the zip file to import may be posted, or JSON that references the remote location to import from. Note that parameters common to both modes must be specified on the querystring. An import job will be started to import the posted or referenced file, and the import job ID will be returned. If the import is successful, the imported course will be registered using the courseId provided.
        *
        * @param string course string : A unique identifier your application will use to identify the course after import. Your application is responsible both for generating this unique ID and for keeping track of the ID for later use.
        * @param bool mayCreateNewVersion bool : Is it OK to create a new version of this course? If this is set to false and the course already exists, the upload will fail. If true and the course already exists then a new version will be created. No effect if the course doesn't already exist.
        * @param multiPart entitymultiPart multiPart : The object to POST
        *
        * @return stringResultSchema
        */
        public function postCoursesImportJobsByCourseByMayCreateNewVersionByEntitymultiPart( $course,  $mayCreateNewVersion, model\multiPart $entitymultiPart)
        {
            try {
                $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/importJobs", client\Methods::POST, client\Formats::JSON));
                $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("course", $course)->addQueryParameter("mayCreateNewVersion", $mayCreateNewVersion)->addQueryParameter("configuration", $this->configuration);
                $request->addFile($entitymultiPart);
                
            $data = $this->getResponse($this->client, $request);
            $class = new model\stringResultSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

            } finally {
                $entitymultiPart->closeFile();
            }
        }

        /**
        * postCoursesImportJobsByCourseByEntitymultiPart
        *
        * Either the actual contents of the zip file to import may be posted, or JSON that references the remote location to import from. Note that parameters common to both modes must be specified on the querystring. An import job will be started to import the posted or referenced file, and the import job ID will be returned. If the import is successful, the imported course will be registered using the courseId provided.
        *
        * @param string course string : A unique identifier your application will use to identify the course after import. Your application is responsible both for generating this unique ID and for keeping track of the ID for later use.
        * @param multiPart entitymultiPart multiPart : The object to POST
        *
        * @return stringResultSchema
        */
        public function postCoursesImportJobsByCourseByEntitymultiPart( $course, model\multiPart $entitymultiPart)
        {
            try {
                $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/importJobs", client\Methods::POST, client\Formats::JSON));
                $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("course", $course)->addQueryParameter("configuration", $this->configuration);
                $request->addFile($entitymultiPart);
                
            $data = $this->getResponse($this->client, $request);
            $class = new model\stringResultSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

            } finally {
                $entitymultiPart->closeFile();
            }
        }

        /**
        * postCoursesImportJobsByCourseByMayCreateNewVersionByEntityimportRequestSchema
        *
        * Either the actual contents of the zip file to import may be posted, or JSON that references the remote location to import from. Note that parameters common to both modes must be specified on the querystring. An import job will be started to import the posted or referenced file, and the import job ID will be returned. If the import is successful, the imported course will be registered using the courseId provided.
        *
        * @param string course string : A unique identifier your application will use to identify the course after import. Your application is responsible both for generating this unique ID and for keeping track of the ID for later use.
        * @param bool mayCreateNewVersion bool : Is it OK to create a new version of this course? If this is set to false and the course already exists, the upload will fail. If true and the course already exists then a new version will be created. No effect if the course doesn't already exist.
        * @param importRequestSchema entityimportRequestSchema importRequestSchema : The object to POST
        *
        * @return stringResultSchema
        */
        public function postCoursesImportJobsByCourseByMayCreateNewVersionByEntityimportRequestSchema( $course,  $mayCreateNewVersion, model\importRequestSchema $entityimportRequestSchema)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/importJobs", client\Methods::POST, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("course", $course)->addQueryParameter("mayCreateNewVersion", $mayCreateNewVersion)->addQueryParameter("configuration", $this->configuration);
            $request->addBody($entityimportRequestSchema);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\stringResultSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * postCoursesImportJobsByCourseByEntityimportRequestSchema
        *
        * Either the actual contents of the zip file to import may be posted, or JSON that references the remote location to import from. Note that parameters common to both modes must be specified on the querystring. An import job will be started to import the posted or referenced file, and the import job ID will be returned. If the import is successful, the imported course will be registered using the courseId provided.
        *
        * @param string course string : A unique identifier your application will use to identify the course after import. Your application is responsible both for generating this unique ID and for keeping track of the ID for later use.
        * @param importRequestSchema entityimportRequestSchema importRequestSchema : The object to POST
        *
        * @return stringResultSchema
        */
        public function postCoursesImportJobsByCourseByEntityimportRequestSchema( $course, model\importRequestSchema $entityimportRequestSchema)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/importJobs", client\Methods::POST, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("course", $course)->addQueryParameter("configuration", $this->configuration);
            $request->addBody($entityimportRequestSchema);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\stringResultSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCoursesImportJobsByImportJobId
        *
        * This method will check the status of an import job.
        *
        * @param string importJobId string : Id received when the import job was submitted to the importJobs resource..
        *
        * @return importResultSchema
        */
        public function getCoursesImportJobsByImportJobId( $importJobId)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/importJobs/{importJobId}", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("importJobId", $importJobId)->addUrlSegment("tenant", $this->tenant)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\importResultSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCoursesImportLinkByCourseByRedirectUrl
        *
        * Returns the link to use to import a course. Use this to get a link that you can form POST to with your import file. A token will be used as part of the URL in order to secure the request to the import link generated.
        *
        * @param string course string : Course ID for the new import
        * @param string redirectUrl string : Url to forward to after import completes
        *
        * @return linkSchema
        */
        public function getCoursesImportLinkByCourseByRedirectUrl( $course,  $redirectUrl)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/importLink", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("course", $course)->addQueryParameter("redirectUrl", $redirectUrl)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\linkSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }

        /**
        * getCoursesImportLinkByCourse
        *
        * Returns the link to use to import a course. Use this to get a link that you can form POST to with your import file. A token will be used as part of the URL in order to secure the request to the import link generated.
        *
        * @param string course string : Course ID for the new import
        *
        * @return linkSchema
        */
        public function getCoursesImportLinkByCourse( $course)
        {
            $request = $this->wrapRequest(new client\RestRequest("/{tenant}/courses/importLink", client\Methods::GET, client\Formats::JSON));
            $request->addUrlSegment("tenant", $this->tenant)->addQueryParameter("course", $course)->addQueryParameter("configuration", $this->configuration);
            
            $data = $this->getResponse($this->client, $request);
            $class = new model\linkSchema;
            $this->ConvertJsonToType($data, $class);
            return $class;

        }
    }
}
?>
