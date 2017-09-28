<?php

/* Software License Agreement (BSD License)
 *
 * Copyright (c) 2010-2017, Rustici Software, LLC
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

    <title>untitled</title>

</head>
<?php

require_once('config.php');
require_once('../ScormEngineService.php');
global $CFG;


//These two parameters are passed in to the redirect url after the importCourseAsync operation returns.
$courseId = $_GET["courseid"];
$tokenId = $_GET["tokenid"];

$statusUrl = $CFG->wwwroot."/AsyncResult.php?tokenid=" . $tokenId;
$detailUrl = $CFG->wwwroot."/CourseDetailSample.php?courseid=" . $courseId;
?>
<script type="javascript">
    function loadDoc() {
        var xhttp;
        xhttp=new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                updateStatusMessage(this);
            }
        };
        xhttp.open("GET", "<?php echo $statusUrl; ?>", true);
        xhttp.send();
    }
    function updateStatusMessage(xhttp) {
        var jsonObj = JSON.parse(xhttp.responseText);
        document.getElementById("status").innerHTML = jsonObj.status;
        document.getElementById("message").innerHTML = jsonObj.statusMessage;
        document.getElementById("progress").innerHTML = jsonObj.progress;
        if (jsonObj.status === "finished") {
            window.location = "<?php echo $detailUrl; ?>";
        } else {
            window.setTimeout(loadDoc, 10000);
        }
    }

</script>
<body onload="loadDoc()">
<div id="status"></div>
<div id="message"></div>
<div id="progress"></div>
</body>
</html>
