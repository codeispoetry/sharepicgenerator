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

$input = substr( $_POST['prompt'], 1, -1 ); // sanitzed input!

echo json_encode( array( 'images' => getPicturesFromAI( $input, 1 ) ) );


function getPicturesFromAI( $input, $count ) {
	if ( empty( $input ) ) {
		return json_encode( 'No input given.' );
	}

	$config['open_api_key'] = configValue( 'OpenAI', 'apikey' );

	$prompt = $input;

	$payload = '{
        "prompt": "' . $prompt . '",
        "n": ' . $count . ',
        "size": "512x512"
        }';

	$ch = curl_init();

	curl_setopt( $ch, CURLOPT_URL, 'https://api.openai.com/v1/images/generations' );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	$headers = array(
		'Content-Type: application/json',
		'Authorization: Bearer ' . $config['open_api_key'],
	);
	curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

	$result = curl_exec( $ch );

	if ( curl_errno( $ch ) ) {
		echo json_encode(
			array(
				'error'   => 1,
				'message' => 'Could not reach AI. It says: ' . curl_error( $ch ),
			)
		);
		die();
	}

	curl_close( $ch );

	$result_json = json_decode( $result );
	if ( ! empty( $result_json->error ) ) {
		echo json_encode(
			array(
				'error'   => 1,
				'message' => $result_json->error->message,
			)
		);
		die();
	}

	$images = array();
	foreach ( $result_json->data as $image ) {
		$images[] = $image->url;
	}

	return $images;
}
