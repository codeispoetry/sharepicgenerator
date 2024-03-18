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


$return = array( 'code' => 0 );
echo json_encode( $return );

function save() {
	$file_number = 1;
	$dir         = getBasePath( 'persistent/user/' . getUser() );
	if ( ! file_exists( $dir ) ) {
		mkdir( $dir, 0777, true );
	}

	parse_str( $_POST['sharepic'], $vars );
	$config = json_decode( $_POST['config'] );

	$file = sprintf( '%s/%s_sharepic%d.json', $dir, $config->tenant, $file_number );

	if ( ! empty( $vars['fullBackgroundName'] ) ) {
		$background = $vars['fullBackgroundName'];
		$target     = sprintf( '%s/%s_sharepic%d.%s', $dir, $config->tenant, $file_number, pathinfo( $background, PATHINFO_EXTENSION ) );

		if ( file_exists( $background ) ) {
			copy( $background, $target );
		}

		$vars['fullBackgroundName'] = $target;
	}

	$content = json_encode( $vars );

	file_put_contents( $file, $content );
}
