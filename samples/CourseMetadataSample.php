<?php

require_once('../ScormEngineService.php');
require_once('config.php');
global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;

$courseid = $_GET['courseid'];

$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey);

$courseService = $ScormService->getCourseService();

$metadata = $courseService->GetMetadata($courseid, 0, 0,1);

echo "<textarea style='height:400px;width:600;'>".$metadata."</textarea>";

?>