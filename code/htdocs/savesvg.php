<?php

$filename = 'tmp/' . uniqid('shpic').'.svg';

$svg = $_POST['svg']; 
$svg = preg_replace('/_klein/', '', $svg );

$svgHeader = '<?xml version="1.0" standalone="no"?>'; // XML node needed by imagick
$svgTag = 'svg'; // tag to search for
preg_match_all("/\<svg(.*?)\>/", $svg, $matches); // Get initial SVG node that may contain missing :xlink

// Für den Safari
if ( !preg_match("/xmlns:xlink/", $matches[1][0]) )
    {
        $tempString = str_replace_nth( 'xmlns=', 'xmlns:xlink=', $matches[1][0], 1 ); // Replace second occurance of xmlns
        $svg = str_replace($matches[1][0], $tempString, $svg);
    }

$svg = preg_replace('/NS([1-9]|[1-9][0-9]):/', 'xlink:', $svg); // Remove offending NS<number>: in front of href tags, will only remove NS0 - NS99


// Für den Firefox
$svg = preg_replace('#([^:])\/\/#', "$1/", $svg); 


$svg = $svgHeader . $svg; // Prefix SVG string with required XML node


file_put_contents( $filename, $svg);

echo basename($filename,'.svg');