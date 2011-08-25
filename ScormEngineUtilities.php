<?php

class ScormEngineUtilities
{
	public static function getCanonicalOriginString($company, $application, $version)
	{
		$companyComponent = preg_replace('/[^a-z0-9]/', '', strtolower($company));
		$applicationComponent = preg_replace('/[^a-z0-9]/', '', strtolower($application));
		$versionComponent = preg_replace('/[^\\w\\.\\-]/', '', strtolower($version));
		
		return "$companyComponent.$applicationComponent.$versionComponent";
	}
}