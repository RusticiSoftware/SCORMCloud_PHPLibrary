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

require_once('config.php');
require_once('../ScormEngineService.php');

global $CFG;

$ServiceUrl = $CFG->scormcloudurl;
$AppId = $CFG->scormcloudappid;
$SecretKey = $CFG->scormcloudsecretkey;
$Origin = $CFG->scormcloudorigin;

$ScormService = new ScormEngineService($ServiceUrl,$AppId,$SecretKey,$Origin);
$courseService = $ScormService->getCourseService();

$token = $courseService->ImportCourseAsync('mycourseid', '/path/to/course/here');

$numAttempts = 0;

while (++$numAttempts < 1000) {
    $importStatus = $courseService->GetAsyncImportResult($token->getTokenId());
    if ($importStatus->getStatus() != "running") {
        $importResults = $importStatus->getImportResults();
        foreach ($importResults as $importResult) {
            if ($importResult->getWasSuccessful()) {
                echo "Import of course titled '".$importResult->getTitle()."' was successful: ".$importResult->getMessage()."\n";
            } else {
                echo "Import of course titled '".$importResult->getTitle()."' failed: ".$importResult->getMessage()."\n";
            }
        }
        break;
    } else {
        echo "Import status: ".$importStatus->getStatus()." ; message: ".$importStatus->getMessage()."\n";
    }
    sleep(1);
}

try {
    $courseService->DeleteCourse('mycourseid');
} catch (Exception $e) {
    // delete failed, so the import above probably failed
}