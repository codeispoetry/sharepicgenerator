<?php

exec('tail -n 1 tmp/ffmpeg.log', $output);

if( preg_match_all('/time=(.*?) /',$output[0],$matches)) {
    echo json_encode(array('currentposition' => end($matches[1])));
    die();
}else{
    echo json_encode(array('currentposition' => 'end'));
    die();
}