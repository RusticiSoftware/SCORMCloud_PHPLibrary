<?php

/**
 * Write To Log File
 *
 * @param string $message test to write to log
 * 
 * @return bool success
 */


function write_log($message) {
	$debug_enabled = false;
	
    if ($debug_enabled){
	$fh = fopen('SCORMCloud_debug.log', 'a');
	
	fwrite($fh, '['.date("D dS M,Y h:i a").'] - '.$message."\n");
	
	fclose($fh);
    }

	return true;

}


?>