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


class Enum{
	
	public function __construct() {
	}
	
/// <summary>
/// Determines to which instance/version the actions in the ScormEngineManager class should be applied
/// </summary>
public function getScope($value)
{
	switch($value)
	{
		case '0':
			return 'LATEST'; // Action applies to latest version/instance only
			break;
		case '1':
			return 'ALL'; // Action applies to latest version/instance only
			break;
		case '2':
			return 'SPECIFIED_ON_EXTERNAL_ID'; // Action applies to version/instance explicitly set on the ExternalPackageId/ExternalRegistrationid
			break;
		default:
			break;
	}
}

/// <summary>
/// Formal parameters for metadata scope
/// </summary>
public function getMetadataScope($value)
{
	switch($value)
	{
		case '0':
			return 'course'; // Package/Course metadata
			break;
		case '1':
			return 'activity'; // A recursive list of all activies
			break;
		default:
			break;
	}
}

/// <summary>
/// Formal parameters for metadata format
/// </summary>
public function getMetadataFormat($value)
{
	switch($value)
	{
		case '0':
			return 'summary'; // Most common high-level information
			break;
		case '1':
			return 'detailed'; // Complete SCORM Metadata for all specified elements
			break;
		default:
			break;
	}
}

/// <summary>
/// Formal paramters for the registration results format
/// </summary>
public function getRegistrationResultsFormat($value)
{
	switch($value)
	{
		case '0':
			return 'course'; // Course Level only - Main high-level information about the registration status
			break;
		case '1':
			return 'activity'; // Summary data about each individual activity in the course.
			break;
		case '2':
			return 'full'; // Complete SCORM Data known about the course.
			break;
		default:
			break;
	}
}

/// <summary>
/// Formal paramters for the data format
/// </summary>
public function getDataFormat($value)
{
	switch($value)
	{
		case '0':
			return 'xml'; // Return data is formatted as XML
			break;
		case '1':
			return 'json'; // Return data is formatted as JSON
			break;
		default:
			break;
	}
}

public function getRegistrationResultsAuthType($value)
{
	switch($value)
	{
		case '0':
			return 'FORM';
			break;
		case '1':
			return 'HTTPBASIC'; 
			break;
		default:
			break;
	}
}

public function getErrorCode($value)
	{
		switch($value)
		{
			case '300':
				return 'INVALID_WEB_SERVICE_RESPONSE';
				break;
			default:
				break;
		}
	}
}
?>
