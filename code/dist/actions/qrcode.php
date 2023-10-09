<?php
require_once 'base.php';
require_once getBasePath( 'lib/functions.php' );
require_once getBasePath( 'lib/upload_functions.php' );
require_once getBasePath( 'lib/user_functions.php' );
$file = sprintf( '%s/%s', getBasePath( 'tmp' ), sanitizeUserinput( $_GET['f'] ) );

header( 'Content-Type: image/png' );
header( 'Content-Length: ' . filesize( $file ) );
header( 'Content-Disposition: attachment; filename="sharepic.png"' );
header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
readfile( $file );
