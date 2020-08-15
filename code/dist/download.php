<?php

require_once('base.php');
require_once('lib/functions.php');

$filename = sanitizeUserinput($_GET['file']);
$downloadname = $_GET['downloadname'] ?: 'sharepic';

if (!in_array($_GET['format'], array('png','pdf','jpg','mp4','zip'))) {
    die("wrong format");
}

switch ($_GET['format']) {
    case 'png':
        $contentType = 'image/png';
        $format = 'png';
        break;
    case 'pdf':
        $contentType = 'application/pdf';
        $format = 'pdf';
        break;
    case 'mp4':
        $contentType = 'video/mp4';
        $format = 'mp4';
        break;
    case 'zip':
        $contentType = 'application/zip';
        $format = 'zip';
        break;
    default:
        $contentType = 'image/jpg';
        $format = 'jpg';
}

debug($filename, $format);

header('Content-Type: ' . $contentType);
header("Content-Length: ".filesize('tmp/' . $filename . '.' . $format));
header('Content-Disposition: attachment; filename="' . $downloadname . '.' . $format . '"');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
readfile('tmp/' . $filename . '.' . $format);

tidyUp();
