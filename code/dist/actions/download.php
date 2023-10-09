<?php

require_once 'base.php';
require_once getBasePath( 'lib/functions.php' );
require_once getBasePath( 'lib/upload_functions.php' );
require_once getBasePath( 'lib/user_functions.php' );

useLocale( 'de_DE' );

session_start();

if ( ! isAllowed() ) {
	die();
}

$filename     = sanitizeUserinput( $_GET['file'] );
$downloadname = $_GET['downloadname'] ?: 'sharepic';

$format      = sanitizeUserinput( $_GET['format'] ) ?: 'png';
$contentType = 'image/' . $format;

$filepath = getBasePath( 'tmp/' . $filename . '.' . $format );

header( 'Content-Type: ' . $contentType );
header( 'Content-Length: ' . filesize( $filepath ) );
header( 'Content-Disposition: attachment; filename="' . $downloadname . '.' . $format . '"' );
header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
readfile( $filepath );
