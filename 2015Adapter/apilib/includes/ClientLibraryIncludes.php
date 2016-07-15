<?php
	require_once (dirname(__FILE__) .  '/ParameterType.php');
	require_once (dirname(__FILE__) .  '/Formats.php');
	require_once (dirname(__FILE__) .  '/Methods.php');
	require_once (dirname(__FILE__) .  '/RestClient.php');
	require_once (dirname(__FILE__) .  '/RestRequest.php');
	require_once (dirname(__FILE__) .  '/BaseClient.php');
	require_once(dirname(__FILE__) . '/multiPart.php');
	foreach (glob(dirname(__FILE__) . "/../generated/RusticiSoftware/ScormContentPlayer/api/model/*.php") as $filename)
	{
    	require_once $filename;
	}
?>