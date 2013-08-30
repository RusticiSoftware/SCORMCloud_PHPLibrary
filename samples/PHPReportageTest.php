<?php
require_once('../ServiceRequest.php');
require_once('../ReportingService.php');
require_once('../ScormEngineService.php');
require_once('../ServiceRequest.php');
require_once('config.php');
global $CFG;

$appId = $CFG->scormcloudappid; 
$pwd = $CFG->scormcloudsecretkey;
$conf = new Configuration('http://cloud.scorm.com/EngineWebServices', $appId, $pwd);
$srvc = new ReportingService($conf);

echo 'Manually add Course ID to test';
$courseId = ""; // Add course ID for quick testing.

$homePage = "/Reportage/reportage.php?appId=$appId";
//$learnerPage = $homePage . "&learnerId=$learnerId";
$coursePage = $homePage . "&courseId=$courseId";

//These parameters won't allow the user to drill down or freely navigate, just view
$reportageAuth = $srvc->GetReportageAuth('NONAV', true); 

//Now we use the authentication token retrieved above as authentication for these links
$securedHomePage = $srvc->GetReportUrl($reportageAuth, $homePage);
//$securedLearnerPage = $srvc->GetReportUrl($reportageAuth, $learnerPage);
$securedCoursePage = $srvc->GetReportUrl($reportageAuth, $coursePage);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Reportage link test</title>
</head>
<body>
	<ul>
		<li><a href="<?=$securedHomePage?>">Reportage Home</a></li>
		
		<li><a href="<?=$securedCoursePage?>">Reportage report for course with id <?=$courseId?></a></li>
	</ul>
</body>
</html>
          
