<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>untitled</title>
	
</head>

<body>
<?php
require_once("config.php");
require_once('../ScormEngineService.php');

global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;


$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey);
$uploadService = $ScormService->getUploadService();

					
$importurl = $CFG->wwwroot."/ImportFinish.php";
$cloudUploadLink = $uploadService->GetUploadUrl($importurl)


?>	

	
<form action="<?php echo $cloudUploadLink; ?>" method="post" enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="filedata" id="file" /> 
<br />
<input type="submit" name="submit" value="Submit" />
</form>
<br><br>

</body>
</html>