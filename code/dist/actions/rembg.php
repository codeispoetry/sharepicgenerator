<?php
require_once 'base.php';
require_once getBasePath( 'lib/functions.php' );
require_once getBasePath( 'lib/upload_functions.php' );
require_once getBasePath( 'lib/user_functions.php' );
useLocale( 'de_DE' );

session_start();

if ( ! isAllowed( true ) ) {
	die( 'not allowed' );
}

$filename = substr( $_POST['filename'], 1, -1 );
$bgcolor  = ( ! empty( $_POST['bgcolor'] ) ) ? substr( $_POST['bgcolor'], 1, -1 ) : '#a0c864';


$new_filename_png = $filename . '.rembg.png';
$new_filename_jpg = $filename . '.rembg.jpg';


$command = sprintf(
	'NUMBA_CACHE_DIR=/tmp rembg i -m u2net_human_seg %s %s 2>&1',
	$filename,
	$new_filename_png
);

exec( $command );

$command = sprintf(
	'convert -background %s -flatten -quality 80  %s %s',
	escapeshellarg( $bgcolor ),
	escapeshellarg( $new_filename_png ),
	escapeshellarg( $new_filename_jpg )
);
exec( $command );

echo json_encode( array( 'filename' => $new_filename_jpg ) );
