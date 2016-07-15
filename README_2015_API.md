# 2015 API Adapter for LocalWS #
Rustici Software 

**Purpose:**
The 2015 PHP API Adapter for LocalWS is intended to allow continued use of your existing PHP application without a major rewrite. The new 2015 API exposed by SCORM Engine currently uses the modern and succinct format of JSON when sending or receiving data. We realize that you may not be ready to change your complete application to take an advantage of this newer API; therefore, we have created an adapter that will use the newer API but continue to return your data in the existing format for the most commonly used methods. <b>Note: Not all methods and services are implemented (see step 1 below).</b>

**Cautions:**
We highly recommend making complete backups of your database(s) and any application files prior to upgrading. We also recommend that you first upgrade against a restored copy of production data in a test environment before making any changes to your actual production environment.

**Prerequisites:**
Before you begin using the PHP API Adapter, you will need to have upgraded to Engine 2015.1.12.1315 or higher.

**2015 API Documentation:**
If you want to know more about our 2015 API then checkout the [API Interactive Documentation](http://rustici-docs.s3.amazonaws.com/engine/2015.1.x/api.html).

**Steps:**
Below are the high-level steps for getting up and running followed by a breakdown of the detail steps. 

**1.** Evaluate if your application code is using any services or methods that have not been implemented by our adapter code (see step 1.1 below).

**2.** Overwrite the existing PHP client library files, NOTE: ***PHP 5.6.13 or greater is needed in order to use the adapter***.
 
**3.** Change your PHP configuration settings and set the **$useNewAPI** flag in the Configuration.php to activate the adapter and use the new 2015 API.

**Detail Steps**
**1.1** Listed below are the methods that have and have not been implemented. If your application code depends on anything that has not been implemented please let us know as we are continually improving our client libraries.
<pre>
	 <b>- CourseService</b>
		- Adapted methods
			- public function DeleteCourse($courseId,$deleteLatestVersionOnly=False)
			- public function DeleteCourseVersion($courseId,$versionId)
			- public function Exists($courseId)
			- public function GetAttributes($courseId,$versionId=Null)
			- public function GetCourseDetail($courseId)
			- public function GetCourseList($courseIdFilterRegex=null)
			- public function GetImportCourseUrl($courseId,$redirectUrl)
			- public function GetPreviewUrl($courseId,$redirectOnExitUrl,$cssUrl=null)
			- public function GetPropertyEditorUrl($courseId,$stylesheetUrl,$notificationFrameUrl)
			- public function ImportCourse($courseId,$absoluteFilePathToZip,$itemIdToImport=null)
			- public function ImportUploadedCourse($courseId,$path,$permissionDomain=null)
			- *public function UpdateAttributes($courseId,$versionId,$attributePairs) 
				- <b>Note: the UpdateAttributes only allows updating the latest versions</b>
	
		- <b>Not supported/implemented (will throw exceptions)</b>
			- public function GetMetadata($courseId, $versionId, $scope, $format)
			- public function GetUpdateAssetsUrl($courseId, $redirectUrl)
			- public function UpdateAssetsFromUploadedFile($courseId, $uploadLocation)
	<hr/>		
	<b>- DebugService</b>
		- Adapted methods
			- public function CloudAuthPing($throw = false);
			- public function CloudPing($throw = false);
			
		- <b>Not supported/implemented (will throw exceptions)</b>
			- <i>none</i>
	<hr/>		
	<b>- RegistrationService</b>
		- Adapted methods
			- public function CreateRegistration($registrationId, $courseId, 
												$learnerId, $learnerFirstName, 
												$learnerLastName, $email = null, 
												$authtype = null, $resultsformat = 'xml', 
												$resultsPostbackUrl = null, $postBackLoginName = null, 
												$postBackLoginPassword = null, $versionId = null)
			- <b>*</b>public function DeleteRegistration($registrationId, $deleteLatestInstanceOnly = False)
				-<b>Note: the DeleteRegistration does not allow deleting a specific instance, </b>
				 <b>      you must always pass false for 2nd parameter</b>
			- public function DeleteRegistrationInstance($registrationId, $instanceId)
			- public function Exists($registrationId)
			- public function GetLaunchHistory($registrationId)
			- public function GetLaunchInfo($launchId)
			- public function GetLaunchUrl($registrationId, $redirectOnExitUrl = null, 
										   $cssUrl = null, $debugLogPointerUrl = null, 
										   $courseTags = null, $learnerTags = null, 
										   $registrationTags = null)
			- public function GetRegistrationDetail($registrationId)
			- public function GetRegistrationList($courseId, $learnerId)
			- public function GetRegistrationListResults($courseId, $learnerId, $resultsFormat)
			- public function GetRegistrationResult($registrationId, $resultsFormat, $dataFormat)
			- public function GetRegistrationResultUrl($registrationId, $resultsFormat, $dataFormat)
			- public function GetRegistrationSummary($registrationId)
			- <b>*</b>public function ResetGlobalObjectives($registrationId, $deleteLatestInstanceOnly = true)
				-<b>Note: the ResetGlobalObjectives does not allow deleting a specific instance,</b> 
				 <b>      you must always pass false for 2nd parameter</b>
			- public function ResetRegistration($registrationId)
			- public function UpdateLearnerInfo($learnerid, $fname, $lname, $newid = null)
			
		- <b>Not supported/implemented (will throw exceptions)</b>
			- public function DeleteRegistrationInstance($registrationId, $instanceId)
			- public function GetLaunchHistory($registrationId)
			- public function GetLaunchInfo($launchId)
			- public function GetRegistrationResultUrl($registrationId, $resultsFormat, $dataFormat)
			- public function UpdateLearnerInfo($learnerid, $fname, $lname, $newid = null)
 
	<hr/>
    - <b>The following services (and all methods) are not supported/implemented (will throw exceptions)</b>
		- UploadService
		- ReportingService
		- FtpService
		- TaggingService
		- AccountService
		- DispatchService
		- InvitationService
		- LrsAccountService
		- ApplicationService
		- CreateNewRequest() Method
	
</pre>	 
	

----------

**2.1** You should have an existing folder that contains your existing PHP client library files, this is typically in your htdocs folder if you are using Apache; this folder will contain the ScormEngineService.php file. You will need overwrite these files with the new PHP client library files. After you have completed this you should have a new folder called **2015Adapter** along side your PHP client library files (e.g. same level as ScormEngineService.php).

----------

**3.1** Now that you have everything installed and upgraded properly, you will need to pass specific parameter values when initializing the ScormEngineService object in your code. For example if you have something similar to this:

<pre>
	//create new instance of service locator.
	$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey);	
</pre> 

You will need to set the parameter values as follows:

 - **$ServiceUrl** : this will  need to be set to the base endpoint for the 2015 API e.g. http://&lt;yourserver:port&gt;/ScormEngineInterface/api/v1/
 - **$AppId** : this will be your tenant name, if you query the enginetenant table in the SCORMEngine database (select tenant_name from enginetenant;) this should give you an idea of the value. most localws installs will be defaultid.
 - **$SecretKey** : this will be a string in the form of "apiusername|apipassword". To get the username and password check your SCORMEngineSettings.properties file that was created when you upgraded Engine. Contained within this file will be an entry for the api basic accounts:
 
<pre>
	&lt;entry key="ApiBasicAccounts"&gt;
    	apiuser : password
	    apiuser2: password2
  	&lt;/entry&gt;
</pre>  


So as an example to create the ScormEngineService
<pre>
	//example settings.
	$ServiceUrl = "http://localhost:8888/ScormEngineInterface/api/v1/";
	$AppId = "defaultid";
	$SecretKey = "apiuser|password";

	$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey);	
</pre> 

**3.2** There is only one setting left to be set. In the Configuration.php, the same level where the ScormEngineService.php file exists, you will need to edit the Configuration.php file and set the following to true:

<pre>
class Configuration{
	//set this to true if you are using the API
	public static <b>$useNewAPI</b> = false;
</pre>
	  
Once that flag is set, along with the other settings mentioned above you should be able to run and test your application.

----------