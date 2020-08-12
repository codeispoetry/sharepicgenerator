<?php

require_once('lib/functions.php');
require_once('lib/gallery_functions.php');

$filename = 'tmp/' . uniqid('shpic') . '.svg';

$svg = $_POST['svg'];
$svg = preg_replace('/_small/', '', $svg);

// XML node needed by imagick
$svgHeader = '<?xml version="1.0" standalone="no"?>';

// tag to search for
$svgTag = 'svg';

// Get initial SVG node that may contain missing :xlink
preg_match_all("/\<svg(.*?)\>/", $svg, $matches);

// For safari
if (!preg_match("/xmlns:xlink/", $matches[1][0])) {
    // Replace second occurance of xmlns
    $tempString = str_replace_nth('xmlns=', 'xmlns:xlink=', $matches[1][0], 1);
    $svg = str_replace($matches[1][0], $tempString, $svg);
}

// Remove offending NS<number>: in front of href tags, will only remove NS0 - NS999
$svg = preg_replace('/NS([1-9]|[1-9][0-9]|[1-9][0-9][0-9]):/', 'xlink:', $svg);

// for firefox
$svg = preg_replace('#([^:])\/\/#', "$1/", $svg);
$svg = $svgHeader . $svg; // Prefix SVG string with required XML node

file_put_contents($filename, $svg);

if (in_array($_POST['format'], array('png','pdf','jpg','mp4'))) {
    $format = $_POST['format'];
} else {
    die("wrong format");
}

$exportWidth = (int) $_POST['width'];
$quality = (int) $_POST['quality'] ?: 75;

convert($filename, $exportWidth, $format, $quality);
if (isset($_POST['addtogallery']) and $_POST['addtogallery'] == "true") {
    saveInGallery($filename);
}

logthis();

$return = [];
$return['basename'] = basename($filename, 'svg');
echo json_encode($return);
