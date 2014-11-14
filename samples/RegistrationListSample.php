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
$Origin = $CFG->scormcloudorigin;

$courseid = $_GET['courseid'];

$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey,$Origin);

$regService = $ScormService->getRegistrationService();

if(isset($courseid)){
	$allResults = $regService->GetRegistrationList($courseid,null);
}else{
	$allResults = $regService->GetRegistrationList(null,null);
}



echo '<form action="CreateRegistrationSample.php" method="GET">';
?>
<h3>Create New Registration</h3>
Email: <input type="text" name="learnerid" /><br/>
First Name:<input type="text" name="learnerfirstname" /><br/>
Last Name:<input type="text" name="learnerlastname" /><br/>
<?php
if (isset($courseid)){
	echo '<input type="hidden" name="courseid" value="'.$courseid.'"/>';
}else{
	echo '<select name="courseid">';
	$courseService = $ScormService->getCourseService();
	$allCourses = $courseService->GetCourseList();
	foreach($allCourses as $course)
	{
		echo '<option value="'.$course->getCourseId().'">'.$course->getTitle().'</option>';
	}
	echo '</select><br/>';
}
?>
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
