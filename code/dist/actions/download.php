<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
useLocale('de_DE');

session_start();

if (!isAllowed()) {
    die();
}

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
    case 'zip':
        $contentType = 'application/zip';
        $format = 'zip';
        break;
    default:
        $contentType = 'image/jpg';
        $format = 'jpg';
}

//debugPic($filename, $format);
$filepath = getBasePath('tmp/' . $filename . '.' . $format);

header('Content-Type: ' . $contentType);
header("Content-Length: ".filesize($filepath));
header('Content-Disposition: attachment; filename="' . $downloadname . '.' . $format . '"');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
readfile($filepath);

logPicture($filename, $format);
