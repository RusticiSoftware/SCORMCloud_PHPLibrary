<?php

/* Software License Agreement (BSD License)
 * 
 * Copyright (c) 2013, Rustici Software, LLC
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

	<title>Activity Provider List Sample</title>
	
</head>

<body>
<h2>Activity Provider List Sample</h2>


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

write_log('Creating lrsAccountService');
$lrsAccountService = $ScormService->getLrsAccountService();
write_log('lrsAccountService Created');

if(isset($_POST['submit']))
{
	$url = $_REQUEST['callbackurl'];
	$lrsAccountService->setAppLrsAuthCallbackUrl($url);

	echo 'Succes!';

}

echo '<form action="ActivityProviderListSample.php" method="POST">';
?>
<h3>Set Auth CallBack Url</h3>
URL: <input type="text" name="callbackurl" /><br/>
<input type="submit" name="submit" value="Submit" />
</form>
<br/><br/>
<?php


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
echo '<a href="AddActivityProviderSample.php">Add Activity Provider</a>';
echo "<br/><br/>";



write_log('Getting listActivityProviders');

$allResults = $lrsAccountService->listActivityProviders();

write_log('AccountList count = '.count($allResults));

echo '<table border="1" cellpadding="5">';
echo '<tr><td>Label</td><td>Key</td><td>Secret</td><td>Is Active</td><td>Auth Type</td><td>Edit</td><td>Delete</td> </tr>';
foreach($allResults as $lrsAccount)
{
	echo '<tr><td>';
	echo $lrsAccount->getAccountLabel();
	echo '</td><td>';
	echo $lrsAccount->getAccountKey();
	echo '</td><td>';
	echo $lrsAccount->getAccountSecret();
	echo '</td><td>';
	echo $lrsAccount->getAccountEnabled();
	echo '</td><td>';
	echo $lrsAccount->getAccountAuthType();
	echo '</td><td>';
	echo '<a href="EditActivityProviderSample.php?accountKey='.$lrsAccount->getAccountKey().
		'&accountLabel='.$lrsAccount->getAccountLabel().
		'&accountEnabled='.$lrsAccount->getAccountEnabled().
		'&accountAuthType='.$lrsAccount->getAccountAuthType().
		'">edit</a>';
	echo '</td><td>';
	echo '<a href="DeleteActivityProviderSample.php?accountKey='.$lrsAccount->getAccountKey().'">delete</a>';
	echo '</td</tr>';
}
echo '</table><br/><br/>';



?>
</body>
</html>