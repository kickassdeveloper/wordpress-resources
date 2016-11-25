<?php
function set_https($string){
	if (is_ssl()) {
		$test = strpos($string, 'https');
		if($test === false){
			$result = str_replace('http', 'https', $string);
			return $result;
		}else{
			return $string;
		}
	}else{
		return $string;
	}
}
?>