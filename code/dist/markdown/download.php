<?php
$filename = sanitize_userinput($_GET['file']);
$downloadname = $_GET['downloadname'] ?: 'sharepic';


$contentType = 'image/png';
$format = 'png';


header('Content-Type: ' . $contentType);
header("Content-Length: ".filesize('tmp/' . $filename . '.' . $format));
header('Content-Disposition: attachment; filename="' . $downloadname . '.' . $format . '"');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
readfile('tmp/' . $filename . '.' . $format);


function sanitize_userinput($var)
{
    return preg_replace('/[^a-zA-Z0-9]/', '', $var);
}
