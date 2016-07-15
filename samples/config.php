<?php

/* Software License Agreement (BSD License)
 * 
 * Copyright (c) 2010-2014, Rustici Software, LLC
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
/// Configuration File
require_once('../ScormEngineUtilities.php');
unset($CFG);

if(!Configuration::$useNewAPI)
{

    //LWS Settings (the old way)
    $CFG->wwwroot = '';  // e.g. "http://localhost/PhpLibrary/samples/";

    //Rustici Software SCORM Cloud API Key Settings
    $CFG->scormcloudurl = 'http://cloud.scorm.com/EngineWebServices/';
    $CFG->scormcloudsecretkey = ''; // e.g. '3nrJQ50o8AOF7qsP0649KfLyXOlfgyxyyt7ecd2U';
    $CFG->scormcloudappid = ''; // e.g. '321WUXJHRT';
    $CFG->scormcloudmanagersecretkey = ''; // e.g. 'JQ53nr0o8AOF7qsP0649KfLyXOlfgyxyyt7ecd2U';
    $CFG->scormcloudappmanagerid = ''; // e.g. '123WUXJHRT';
    $CFG->scormcloudorigin = ScormEngineUtilities::getCanonicalOriginString('Your Company', 'Your Application', 'Version 2.0');

}
else {

    //Setting values for using the API Adapter.
    $CFG->wwwroot = '';  // e.g. "'http://localhost/samples/'";

    //2015: must be changed to point the api base endpoint
    $CFG->scormcloudurl =  ''; //e.g. 'http://localhost:8888/ScormEngineInterface/api/v1/';

    //2015: must be changed to username|password for api user.
    $CFG->scormcloudsecretkey = ''; // e.g. 'your_api_user|your_api_password";
    $CFG->scormcloudappid = ''; //e.g. 'defaultid'; //this will be the tenant id.
    $CFG->scormcloudmanagersecretkey = ''; // e.g. 'JQ53nr0o8AOF7qsP0649KfLyXOlfgyxyyt7ecd2U';
    $CFG->scormcloudappmanagerid = ''; // e.g. '123WUXJHRT';
    $CFG->scormcloudorigin = ScormEngineUtilities::getCanonicalOriginString('Your Company', 'Your Application', 'Version 2.0');


}
?>
