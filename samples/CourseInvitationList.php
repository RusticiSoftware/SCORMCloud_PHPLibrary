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

	<title>Course Invitation List</title>
	
</head>

<body>
<a href="CourseListSample.php">Course List</a>

<h2>Course Invitations</h2>
<br/><br/>
<?php
require_once('../ScormEngineService.php');
require_once('../ServiceRequest.php');
require_once('config.php');
global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;
$Origin = $CFG->scormcloudorigin;

$courseid = $_GET['courseid'];

$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey,$Origin);

$invService = $ScormService->getInvitationService();

$response = $invService->GetInvitationList(null,$courseid);

$xml = simplexml_load_string($response);

?>
<table border="1" cellpadding="5">
<?php

foreach ($xml->invitationlist->invitationInfo as $invInfo)
{
	echo '<tr>';
	echo "<td>" . $invInfo->createdDate . "</td>";
	echo "<td>" . $invInfo->subject . "</td>";
	echo "<td><a href='InvitationInfo.php?invid=" . $invInfo->id . "'>details</a></td>";
	if ($invInfo->allowLaunch == "true"){
		echo "<td><a href='InvitationChangeStatus.php?courseid=".$courseid."&invid=" . $invInfo->id . "&enable=false'>active</a></td>";
	} else {
		echo "<td><a href='InvitationChangeStatus.php?courseid=".$courseid."&invid=" . $invInfo->id . "&enable=true'>inactive</a></td>";
	}
	if ($invInfo->public == "true"){
		if ($invInfo->allowNewRegistrations == "true"){
			echo "<td><a href='InvitationChangeStatus.php?courseid=".$courseid."&invid=" . $invInfo->id . "&enable=" . $invInfo->allowLaunch . "&open=false'>open</a></td>";
		} else {
			echo "<td><a href='InvitationChangeStatus.php?courseid=".$courseid."&invid=" . $invInfo->id . "&enable=" . $invInfo->allowLaunch . "&open=true'>closed</a></td>";
		}
	} else {
		echo "<td>(not public)</td>";
	}
	echo '</tr>';
}


?>

</table>
<br/><br/>
<h3>Create new invitation</h3>
<form action="CreateInvitationSample.php" method="post" enctype="multipart/form-data">
	
<input type="hidden" name="courseid" value="<?= $courseid?>"  />
<br/>
Sender email: <input type="text" name="creatingUserEmail">
<br/>
<input type="checkbox" name="send"> send
<br/>
<input type="checkbox" name="public"> public
<br />
To addresses: <input type="text" name="addresses"> (comma-delimited)
<br />
<input type="submit" name="submit" value="Submit" />
</form>



<br/><br/>
<!--<textarea style="height:600px;width:1000px;"><?=$response?></textarea>-->


</body>
</html>
