<?php

$filename = 'tmp/' . uniqid('shpic').'.svg';

$svg = $_POST['svg']; 
$svg = preg_replace('/_small/', '', $svg );

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

$format = ($_POST['format'] && $_POST['format'] == 'pdf') ? 'pdf' : 'png';
$exportWidth = (int) $_POST['width'];
convert( $filename, $exportWidth, $format );

$return = [];
$return['basename'] =  basename($filename,'svg');
echo json_encode( $return );






function convert( $filename, $width, $format ){

    $command = sprintf("inkscape %s --export-width=%d --export-{$format}=%s",    
            $filename ,
            $width,
            'tmp/' . basename($filename, 'svg')  . $format);

    exec( $command );
}


function sanitize_filename( $var  ){
	return preg_replace('/[^a-zA-Z0-9]/','', $var );
}
