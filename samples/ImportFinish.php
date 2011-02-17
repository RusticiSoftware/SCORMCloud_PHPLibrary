<?php

require_once('../ScormEngineService.php');
require_once('config.php');
global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;


$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey);
$courseService = $ScormService->getCourseService();

$courseId = uniqid();


$importResult = $courseService->ImportUploadedCourse($courseId,$_GET['location']);


//echo var_dump($importResult);

header( 'Location: '.$CFG->wwwroot.'/CourseListSample.php' ) ;


?>