<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Course List Sample</title>
	
</head>

<body>
<h2>Course List Sample</h2>


<?php
require_once('../ScormEngineService.php');
require_once('config.php');
global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;

write_log('Creating ScormEngineService');
$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey);
write_log('ScormEngineService Created');

$debugService = $ScormService->getdebugService();
if ($debugService->CloudPing()){
	echo "<p style='color:green'>CloudPing call was successful.</p>";
} else {
	echo "<p style='color:red'>CloudPing call was not successful.</p>";
}
if ($debugService->CloudAuthPing()){
	echo "<p style='color:green'>CloudAuthPing call was successful.</p>";
} else {
	echo "<p style='color:red'>CloudAuthPing call was not successful.</p>";
}
echo "<br/><br/>";
echo '<a href="ImportSample.php">Import New Package</a>';
echo "<br/><br/>";

write_log('Creating CourseService');
$courseService = $ScormService->getCourseService();
write_log('CourseService Created');

write_log('Getting CourseList');
$allResults = $courseService->GetCourseList();
write_log('CourseList count = '.count($allResults));

echo '<table border="1" cellpadding="5">';
echo '<tr><td>Course Id</td><td>Title</td><td>Registrations</td><td></td><td>metadata</td><td>Properties</td></tr>';
foreach($allResults as $course)
{
	echo '<tr><td>';
	echo $course->getCourseId();
	echo '</td><td>';
	echo $course->getTitle();
	echo '</td><td>';
	echo '<a href="RegistrationListSample.php?courseid='.$course->getCourseId().'">'.$course->getNumberOfRegistrations().'</a>';
	echo '</td><td>';
	echo '<a href="DeletePackageSample.php?id='.$course->getCourseId().'">Delete Package</a>';
	echo '</td><td>';
	echo '<a href="CourseMetadataSample.php?courseid='.$course->getCourseId().'">metadata</a>';
	echo '</td><td>';
	echo '<a href="CoursePropertiesSample.php?courseid='.$course->getCourseId().'">properties</a>';
	echo '</td><td>';
	$prevUrl = $courseService->GetPreviewUrl($course->getCourseId(),$CFG->wwwroot."/CourseListSample.php");
	echo '<a href="'.$prevUrl.'">Preview</a>';
	echo '</td></tr>';
}
echo '</table><br/><br/>';

$reportService = $ScormService->getReportingService();
$repAuth = $reportService->GetReportageAuth("freenav",true);
$reportageUrl = $reportService->GetReportageServiceUrl()."Reportage/reportage.php?appId=".$AppId;
$reportUrl = $reportService->GetReportUrl($repAuth,$reportageUrl);


echo '<h3><a href="'.$reportUrl.'">Go to reportage for your App Id.</a></h3>';

?>
</body>
</html>