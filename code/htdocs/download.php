<?php

$filebasename = sanitize_filename( $_GET['file'] );

convert( $filebasename );
output( $filebasename );


function output( $filebasename ){
    $format = 'png';
    header('Content-Type: image/png');
	header('Content-Disposition: attachment; filename="sharepic.'. $format .'"');
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	readfile( 'tmp/' . $filebasename . '.' .  $format );
}


function convert( $filebasename ){
    $command = sprintf("inkscape %s --export-width=600 --export-png=%s",    
            'tmp/' .$filebasename . '.svg',
            'tmp/' .$filebasename . '.png');

    exec( $command );
}


function sanitize_filename( $var  ){
	return preg_replace('/[^a-zA-Z0-9]/','', $var );
}
