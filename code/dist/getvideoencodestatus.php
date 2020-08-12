<?php

require_once('lib/functions.php');

$logfile = sprintf('tmp/%s.log', basename($_GET['videofile'], '.mp4'));

$command = sprintf('tail -n 1 %s', $logfile);
exec($command, $output);

if (preg_match_all('/time=(.*?) /', $output[0], $matches)) {
    echo json_encode(array('currentposition' => timecode2seconds(end($matches[1]))));
    die();
} else {
    echo json_encode(array('currentposition' => 'end'));
    die();
}
