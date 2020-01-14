<?php

exec('tail -n 1 tmp/ffmpeg.log', $output);

if( preg_match_all('/time=(.*?) /',$output[0],$matches)) {
    echo json_encode(array('currentposition' => timecode2seconds(end( $matches[1]))));
    die();
}else{
    echo json_encode(array('currentposition' => 'end'));
    die();
}


function timecode2seconds( $timecode ){
    $parts = explode(":",$timecode);
    $parts = array_reverse($parts);
    $seconds = 0;
    $multiplier = 1;
    foreach($parts AS $part){
        $seconds += $part * $multiplier;
        $multiplier *= 60;
    }

    return $seconds;
}