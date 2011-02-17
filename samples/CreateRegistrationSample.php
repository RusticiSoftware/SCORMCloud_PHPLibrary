<?php
require_once('../ScormEngineService.php');
require_once('config.php');
global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;

$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey);

$regService = $ScormService->getRegistrationService();

$regId = uniqid(rand(), true);
$courseId = $_GET['courseid'] ;
$learnerId = $_GET['learnerid'];
$learnerFirstName = $_GET['learnerfirstname'] ;
$learnerLastName = $_GET['learnerlastname'] ;

//echo $regId . '<br>';
//echo $courseId . '<br>';
//echo $learnerId . '<br>';
//echo $learnerFirstName . '<br>';
//echo $learnerLastName . '<br>';

//CreateRegistration($registrationId, $courseId, $learnerId, $learnerFirstName, $learnerLastName)
$regService->CreateRegistration($regId, $courseId, $learnerId, $learnerFirstName, $learnerLastName);

header('Location: '.$CFG->wwwroot.'/RegistrationListSample.php?courseid='.$courseId) ;
?>