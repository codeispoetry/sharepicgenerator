<?php

$filebasename = sanitize_filename( $_GET['file'] );

$format = ($_GET['pdf'] && $_GET['pdf'] == 'true') ? 'pdf' : 'png';

convert( $filebasename, $format );
output( $filebasename, $format );


function output( $filebasename, $format ){
    
    header('Content-Type: image/png');
	header('Content-Disposition: attachment; filename="sharepic.'. $format .'"');
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	readfile( 'tmp/' . $filebasename . '.' .  $format );
}


function convert( $filebasename, $format ){
    $exportWidth = (int) $_GET['width'];
    $command = sprintf("inkscape %s --export-width=%d --export-{$format}=%s",    
            'tmp/' .$filebasename . '.svg',
            $exportWidth,
            'tmp/' .$filebasename . '.' . $format);

    exec( $command );
}


function sanitize_filename( $var  ){
	return preg_replace('/[^a-zA-Z0-9]/','', $var );
}
