Software License Agreement (BSD License)

Copyright (c) 2010-2011, Rustici Software, LLC
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
    * Neither the name of the <organization> nor the
      names of its contributors may be used to endorse or promote products
      derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL Rustici Software, LLC BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.


SCORM Cloud Service PHP Library
Rustici Software

About:
The SCORM Cloud PHP Library is intended to aid in the integration of the SCORM Cloud service API into PHP applications.  This library does not cover all possible SCORM Cloud service API calls, but it does cover the basics. Descriptions of the full API can be found here: http://cloud.scorm.com/EngineWebServices/doc/SCORMCloudAPI.html

Using the Library:
To use the library, include the accompanying files in your PHP project and require the ScormEngineService.php file.

The files inside the samples folder are not necessary for the functionality of the library. They are included with the library as a sample app. This sample app displays how to do most of the basic functionalities of the library.  To use this sample app, you will need to customize the config.php file with your credentials, providing your appId and your secret key (you get these from the SCORM Cloud site on the apps page).  Once configured and placed on your web server, simply browse to the samples/CourseListSample.php to get started. Note that the sample files do depend on their relative placement to the main Library files.


Updates:

v1.3.1
5.1.2012
* Added Invitation Service to manage SCORM Cloud invitations through the new Invitation Service in the SCORM Cloud API.
* Added sample invitation service implementation to the samples folder (demo app). 
* Modified the import sample to use a more streamlined process which posts and imports a course package directly into the SCORM Cloud instead of using the 2-part process of uploading and then importing. The ImportFinish.php is no longer used and is deleted.

v1.2.1
2.16.2011
* Signature Changes for this release:
  (Note that this release does change things more than we like, but our main goal was to create some uniformity with the other API libraries (java, .net, etc.). We tried to maintain backwards compatibility where we could.)
** Added CourseService::GetAttributes(courseid,versionid) function to get the set of modifiable course attributes and their values. Returns a dictionary hash array of the attributes and to their values.
** Added CourseService::UpdateAttributes(courseid,versionid,attributepairs) function to update attributes. Returns a dictionary hash array of updated attributes.
** Added UploadService::DeleteFile(location) function to delete files that have been uploaded to the SCORM Cloud server. This function will not delete an imported course, but instead will delete files that have been uploaded to a transition area on the server prior to import.
** Added RegistrationService::UpdateLearnerInfo(learnerid,fname,lname,newid) function to update a learner's firstname, lastname and optionally assign a new learnerid.
**Added the DebugService and the CloudPing() and CloudAuthPing() functions.  CloudPing makes sure the SCORM Cloud server is reachable. The CloudAuthPing checks your appId credentials against the SCORM Cloud.  Both return boolean values.

v1.1.3
10.28.2010

* Added Exists method to CourseService and RegistrationService
* Updated GetPropertyUrl method in CourseService to use rustici.course.properties service call

v1.1.2
10.26.2010

*Added simplified ImportCourse call that automates the two step upload / import process

v1.1.1
2.2.2010

* Added async upload with callback url
* Added access to Reportage widgets via ReportingService.php
* Added tagging support for Reportage integration
