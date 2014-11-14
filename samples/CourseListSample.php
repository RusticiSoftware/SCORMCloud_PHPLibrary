<?php

/* Software License Agreement (BSD License)
 * 
 * Copyright (c) 2010-2011, Rustici Software, LLC
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the <organization> nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL Rustici Software, LLC BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

?>

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
$Origin = $CFG->scormcloudorigin;

write_log('Creating ScormEngineService');
$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey,$Origin);
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
echo '<tr><td>Course Id</td><td>Title</td><td>Registrations</td><td></td><td>metadata</td><td>Detail</td><td>Properties</td> </tr>';
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
	echo '<a href="CourseDetailSample.php?courseid='.$course->getCourseId().'">detail</a>';
	echo '</td><td>';
	echo '<a href="CoursePropertiesSample.php?courseid='.$course->getCourseId().'">properties</a>';
	echo '</td><td>';
	echo '<a href="CourseInvitationList.php?courseid='.$course->getCourseId().'">invitations</a>';
	echo '</td><td>';
	$prevUrl = $courseService->GetPreviewUrl($course->getCourseId(),$CFG->wwwroot."/CourseListSample.php","https://cloud.scorm.com/sc/css/cloudPlayer/cloudstyles.css");
	echo '<a href="'.$prevUrl.'">Preview</a>';
	echo '</td><td>';
	echo '<a href="CourseExistsSample.php?courseid='.$course->getCourseId().'">Exists?</a>';
	echo '</td</tr>';
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