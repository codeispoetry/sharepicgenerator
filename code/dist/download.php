<?php

$filename = sanitize_filename($_GET['file']);

$contentType = 'image/png';
$format = 'png';

if ($_GET['format'] && $_GET['format'] == 'pdf') {
    $contentType = 'application/pdf';
    $format = 'pdf';
}

header('Content-Type: ' . $contentType);
header('Content-Disposition: attachment; filename="sharepic.' . $format . '"');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
readfile('tmp/' . $filename . '.' . $format);

unlink('tmp/' . $filename . '.' . $format);
unlink('tmp/' . $filename . '.svg');


function sanitize_filename($var)
{
    return preg_replace('/[^a-zA-Z0-9]/', '', $var);
}
