<?php

require_once('../ScormEngineService.php');
require_once('config.php');
global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;

$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey);

$courseid = $_GET['id'];

$courseService = $ScormService->getCourseService();
//echo gettype($courseService);
$courseService->DeleteCourse($courseid, 'false');

//echo 'Course '.$courseid.' deleted';
header( 'Location: '.$CFG->wwwroot.'/CourseListSample.php' ) ;

?>