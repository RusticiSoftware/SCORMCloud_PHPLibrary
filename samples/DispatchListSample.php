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

	<title>Dispatch List Sample</title>
	
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


$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey,$Origin);

$courseService = $ScormService->getCourseService();

$dispatchService = $ScormService->getDispatchService();

//echo '<pre>';
  //  print_r ($attributes);
   // echo '</pre>';

echo '<form action="CreateDestinationSample.php" method="GET">';
?>
<h3>Create New Destination</h3>
Name: <input type="text" name="destname" /><br/>
Tags:<input type="text" name="desttags" /><br/>
<input type="submit" name="submit" value="Submit" />
</form>
<br/><br/>

<?php
echo '<form action="CreateDispatchSample.php" method="GET">';
?>
<h3>Create New Dispatch</h3>
Destination ID: <input type="text" name="destid" /><br/>
Course ID: <input type="text" name="courseid" /><br/>
Tags:<input type="text" name="disptags" /><br/>
<input type="submit" name="submit" value="Submit" />
</form>
<br/><br/>
<?php

$dests = $dispatchService->GetDestinationList(1);

//Destination List
echo '<h3>Destination List</h3>';
echo '<table border="1" cellpadding="5">';
echo '<tr><td>Destination ID Id </td> <td> Destination Name </td> </tr>';
foreach($dests as $dest)
{
	echo '<tr><td>';
	echo $dest->getId();
	echo '</td><td>';
	echo $dest->getName();
	echo '</td><tr>';
}
echo '</table><br/><br/>';

echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<br/>';

$disps = $dispatchService->GetDispatchList(1);

//Dispatch List
echo '<h3>Dispatch List</h3>';
echo '<table border="1" cellpadding="5">';
echo '<tr><td>Dispatch ID Id</td><td>Destination Id</td> <td> Course ID </td> <td> Enabled </td> <td> Update Date </td> <td> Download </td> </tr>';
foreach($disps as $disp)
{
	echo '<tr><td>';
	echo $disp->getId();
	echo '</td><td>';
	echo $disp->getDestinationId();
	echo '</td><td>';
	echo $disp->getCourseId();
	echo '</td><td>';
	echo $disp->getEnabled();
	echo '</td><td>';
	echo $disp->getUpdateDate();
	echo '</td><td>';
	echo '<a class="thickbox" href="'.$dispatchService->GetDispatchDownloadUrl($disp->getDestinationId(), $disp->getCourseId(), $disp->getId() ).'">Download</a>';
	
	echo '</td><tr>';
}
echo '</table><br/><br/>';
?>
</body>
</html>
