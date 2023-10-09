<?php
require_once 'base.php';
require_once getBasePath( 'lib/functions.php' );
require_once getBasePath( 'lib/log_functions.php' );
require_once getBasePath( 'lib/user_functions.php' );
useLocale( 'de_DE' );

session_start();

if ( ! isAllowed() ) {
	die();
}

$filename = getBasePath( 'tmp/' . uniqid( 'shpic' ) . '.svg' );

$svg    = $_POST['svg'];
$config = json_decode( $_POST['config'] );
$svg    = preg_replace( '/_small/', '', $svg );

// XML node needed by imagick
$svgHeader = '<?xml version="1.0" standalone="no"?>';

// tag to search for
$svgTag = 'svg';

// Get initial SVG node that may contain missing :xlink
preg_match_all( '/\<svg(.*?)\>/', $svg, $matches );

// For safari
if ( ! preg_match( '/xmlns:xlink/', $matches[1][0] ) ) {
	// Replace second occurance of xmlns
	$tempString = str_replace_nth( 'xmlns=', 'xmlns:xlink=', $matches[1][0], 1 );
	$svg        = str_replace( $matches[1][0], $tempString, $svg );
}

// Remove offending NS<number>: in front of href tags, will only remove NS0 - NS999
$svg = preg_replace( '/NS([1-9]|[1-9][0-9]|[1-9][0-9][0-9]):/', 'xlink:', $svg );

// For firefox
$svg = preg_replace( '#([^:])\/\/#', '$1/', $svg );

// set correct path to directories
$svg = preg_replace( '/xlink:href="..\/..\/tmp\//', 'xlink:href="' . getBasePath( 'tmp' ) . '/', $svg );
$svg = preg_replace( '/xlink:href="\/tmp\//', 'xlink:href="' . getBasePath( 'tmp' ) . '/', $svg );
$svg = preg_replace( '/xlink:href="\/assets\//', 'xlink:href="' . getBasePath( 'assets' ) . '/', $svg );
$svg = preg_replace( '/xlink:href="\/persistent\//', 'xlink:href="' . getBasePath( 'persistent' ) . '/', $svg );
$svg = preg_replace( '/xlink:href="..\/..\/persistent\//', 'xlink:href="' . getBasePath( 'persistent' ) . '/', $svg );
$svg = preg_replace( '/xlink:href="..\/..\/tenants\//', 'xlink:href="' . getBasePath( 'tenants' ) . '/', $svg );

// Remove artifacts eventually left by misuse
$svg = preg_replace( '/<image width="0" height="0"(.*?)<\/image>/', '', $svg );


// Prefix SVG string with required XML node
$svg = $svgHeader . $svg;

file_put_contents( $filename, $svg );

$exportWidth = (int) $_POST['width'];

$format = 'png';
if ( isset( $config->format ) && in_array( $config->format, array( 'png', 'jpg' ) ) ) {
	$format = $config->format;
}

convert( $filename, $exportWidth, $format );

$return = array();

exec(
	sprintf(
		'qrencode -s 4 -o %s https://%s%s 2>&1',
		getBasePath( 'tmp/qrcode_' . basename( $filename, '.svg' ) . '.png' ),
		$_SERVER['HTTP_HOST'],
		'/actions/qrcode.php?f=' . basename( $filename, '.svg' ) . '.' . $format
	)
);



$return['basename'] = basename( $filename, '.svg' );
$return['format']   = $format;

logDownload( array( 'sharepicid' => $return['basename'] ) );
logPicture( $return['basename'] );

echo json_encode( $return );
