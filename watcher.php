<?php

if( 200 === is_reachable('http://sharepicgenerator.de') ){
    die();
}

$message = "Warning! Website not reachable."; 

for($i = 0; $i <= 3; $i++) {
    exec(sprintf('espeak "%s"', $message));
    sleep(2);
}



function is_reachable($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_exec($ch);
    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $retcode;
}