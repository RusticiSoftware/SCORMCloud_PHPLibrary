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
require_once('config.php');
global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;

$regid = $_GET['regid'];

$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey);

$regService = $ScormService->getRegistrationService();

//show Registration Summary
$regSummary = $regService->GetRegistrationSummary($regid);
echo $regSummary->getComplete();
echo '<br>';
echo $regSummary->getSuccess();
echo '<br>';
echo $regSummary->getTotalTime();
echo '<br>';
echo $regSummary->getScore();
echo '<br>';
echo '<br>';
//show Launch History
$allResults = $regService->GetLaunchHistory($regid);

echo '<table border="1" cellpadding="5">';
echo '<tr><td>Completion</td><td>Satisfaction</td><td>Measure Status</td><td>Launch Time</td></tr>';


foreach($allResults as $result)
{
	echo '<tr><td>';
	echo $result->getCompletion();
	echo '</td><td>';
	echo $result->getSatisfaction();
	echo '</td><td>';
	echo $result->getMeasureStatus();
	echo '</td><td>';
	echo $result->getLaunchTime();
	echo '</td></tr>';
}
echo '</table>';
?>
</body>
</html>