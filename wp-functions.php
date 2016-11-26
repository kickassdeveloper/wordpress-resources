<?php
// Function for transforming urls from http to https
// The function checks if the ssl is activate, 
// else returns the original string.
// If the ssl is active it ckecks if the link is https,
// if it is returns it, else it converts the link https,
// and then returns it.

function set_https($string){// $string is the passing argument
	if (is_ssl()) {
		$test = strpos($string, 'https:');//checks if the link has https in it, if so it returns true
		if($test === false){
			$result = str_replace('http:', 'https:', $string);
			//swaps the http: , with https: (   ":"" is for so i  you can use http://example.org/how-http-works/' without transforming the secon http to https)
			return $result;
		}else{
			return $string;
		}
	}else{
		return $string;
	}
}
?>