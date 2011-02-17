<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Registration List Sample</title>
	
</head>

<body>
<a href="CourseListSample.php">Course List</a>
<br/><br/>
<?php
require_once('../ScormEngineService.php');
require_once('../ServiceRequest.php');
require_once('../CourseData.php');
require_once('config.php');
global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;

$courseid = $_GET['courseid'];

$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey);

$regService = $ScormService->getRegistrationService();

if(isset($courseid)){
	$allResults = $regService->GetRegistrationList(null,$courseid);
}else{
	$allResults = $regService->GetRegistrationList(null,null);
}



echo '<form action="CreateRegistrationSample.php" method="GET">';
echo '<input type="hidden" name="courseid" value="'.$courseid.'"/>';
?>
<h3>Create New Registration</h3>
Email: <input type="text" name="learnerid" /><br/>
First Name:<input type="text" name="learnerfirstname" /><br/>
Last Name:<input type="text" name="learnerlastname" /><br/>
<input type="submit" name="submit" value="Submit" />
</form>
<br/><br/>
<?php



echo '<table border="1" cellpadding="5">';
echo '<tr><td></td><td>Registration Id</td><td>Course Id</td><td>completion</td><td>success</td><td>total time</td><td>score</td><td></td></tr>';
foreach($allResults as $result)
{
	$launchUrl = $regService->GetLaunchUrl($result->getRegistrationId(),$CFG->wwwroot."/RegistrationListSample.php?courseid=".$courseid);
	echo '<tr><td>';
	echo '<a class="thickbox" href="'.$launchUrl.'" >Launch</a>';
	echo '</td><td>';
	echo $result->getRegistrationId();
	echo '</td><td>';
	echo $result->getCourseId();
	echo '</td><td>';
	$regResults = $regService->GetRegistrationResult($result->getRegistrationId(),0,'xml');
	//echo $regResults;
	$xmlResults = simplexml_load_string($regResults);
	echo $xmlResults->registrationreport->complete;
	echo '</td><td>';
	echo $xmlResults->registrationreport->success;
	echo '</td><td>';
	echo $xmlResults->registrationreport->totaltime;
	echo '</td><td>';
	echo $xmlResults->registrationreport->score;
	echo '</td><td>';
	echo '<a href="LaunchHistorySample.php?regid='.$result->getRegistrationId().'">Launch History</a>';
	echo '</td></tr>';
}
echo '</table><br/><br/>';

$reportService = $ScormService->getReportingService();
$repAuth = $reportService->GetReportageAuth("freenav",true);
$reportageUrl = $reportService->GetReportageServiceUrl()."Reportage/reportage.php?appId=".$AppId."&courseId=".$courseid;
$reportUrl = $reportService->GetReportUrl($repAuth,$reportageUrl);


echo '<h3><a href="'.$reportUrl.'">Go to reportage for this course.</a></h3>';
?>
</body>
</html>