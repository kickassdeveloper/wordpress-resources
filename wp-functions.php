<?php
function set_https($string){
    $test = strpos($string, 'https');
    if($test === false){
         $result = str_replace('http', 'https', $string);
         return $result;
    }else{
    return $string;
    }
}
?>