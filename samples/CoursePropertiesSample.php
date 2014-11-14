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


require_once('../ScormEngineService.php');
require_once('config.php');
global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;
$Origin = $CFG->scormcloudorigin;

$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey,$Origin);

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
            <option value="true">true</option>
            <option value="false">false</option>
    </select>
	<input type="hidden" name="courseid" value="<?php echo $courseId; ?>"/>
	<input type="submit" value="submit"/>
</form>

<form action="CoursePropertiesSample.php" method="Get">
	
	Attribute:<select name="att">
		<?php
		foreach ($attributes as $key => $value)
        {
			if ($value != 'true' && $value != 'false')
			{
				echo "<option value='" .$key."'>" .$key."</option>";
			}
        }

		?>	
	</select>
	
	&nbsp;&nbsp;&nbsp;
	<input type="text" name="attval">
	<input type="hidden" name="courseid" value="<?php echo $courseId; ?>"/>
	<input type="submit" value="submit"/>
</form>
