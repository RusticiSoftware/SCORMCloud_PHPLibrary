<?php

require_once('../ScormEngineService.php');
require_once('config.php');
global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;

$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey);

$courseId = $_GET['courseid'];

$courseService = $ScormService->getCourseService();
$propsEditorUrl = $courseService->GetPropertyEditorUrl($courseId,Null,Null);


//This area is where we collect the attribut values from the form to send to the UpdateAttributes call.
$att = $_GET['att'];
$attval = $_GET['attval'];

if (isset($att) && isset($attval) && $attval != '')
{
	
	$paramAtts = array($att => $attval);
	//If you have more attributes to send, just add more to the $paramAtts array.
	$changedAtts = $courseService->UpdateAttributes($courseId,Null,$paramAtts);
	
	echo "<h2>Changed Attributes</h2>";
	foreach ($changedAtts as $key => $value)
    {
     	echo "Attribute <b>" .$key."</b> was changed to <b>" .$value."</b>.";	
	}
}

//getting the attributes from the cloud.  the returned values are what can be modified using the updateAttributes
//note that below I do filter the attributes to only display the true/false attributes in this sample.
$attributes = $courseService->GetAttributes($courseId);

?>
<br/>
<a href="CoursePropertiesSample.php?courseid=<?php echo $courseId; ?>">Refresh</a>
<br/>
<h2>Course Properties Editor</h2>
<br/>
<iframe width="800" height="400" src="<?php echo $propsEditorUrl; ?>" ></iframe>
<br/><br/>
<h2>Direct Attribute Updates:</h2>



<form action="CoursePropertiesSample.php" method="Get">
	
	Attribute:<select name="att">
		<?php
		foreach ($attributes as $key => $value)
        {
            if ($value == 'true' || $value == 'false')
			{
				echo "<option value='" .$key."'>" .$key."</option>";
			}
        }

		?>
		
	</select>
	
	&nbsp;&nbsp;&nbsp;
	<select name="attval">
		<option value=""></option>
		<option value="true">true</option>
		<option value="false">false</option>
	</select>
	<input type="hidden" name="courseid" value="<?php echo $courseId; ?>"/>
	<input type="submit" value="submit"/>
</form>
