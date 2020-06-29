<?php
$basename = sanitize_userinput($_GET['basename']);
$downloadname = $_GET['downloadname'] ?: 'sharepic';


header('Content-Type: application/zip');
header("Content-Length: ".filesize('tmp/' . $basename . '.zip'));
header('Content-Disposition: attachment; filename="' . $downloadname . '.zip"');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
readfile('tmp/' . $basename . '.zip');

function sanitize_userinput($var)
{
    return preg_replace('/[^a-zA-Z0-9]/', '', $var);
}


