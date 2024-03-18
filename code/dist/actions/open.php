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

if ( ! $content = open() ) {
	$return = array( 'code' => 1 );
	echo json_encode( $return );
	die();
}

$return = array(
	'code'    => 0,
	'content' => open(),
);
echo json_encode( $return );


function open() {
	$file_number = (int) $_POST['file_number'];
	$tenant = preg_replace( '/[^a-zA-Z]/', '', $_POST['tenant'] );


	$file = sprintf(
		'../persistent/user/%s/%s_sharepic%d.json',
		getUser(),
		$tenant,
		$file_number
	);

	if ( ! file_exists( $file ) ) {
		return false;
	}

	return file_get_contents( $file );
}
