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

$input    = substr( $_POST['text'], 1, -1 );
$result   = getAnswerFromAI( $input );
$response = array();

$suggestions = preg_split( '/[0-9]\. /', $result->choices[0]->text );

foreach ( $suggestions as $suggestion ) {
	$trimmed = trim( preg_replace( "/\n/", ' ', $suggestion ) );
	if ( empty( $trimmed ) ) {
		continue;
	}
	$response[] = $trimmed;
}
file_put_contents( getBasePath( 'log/logs/ai.log' ), $input . ' => ' . json_encode( $response ) . "\n", FILE_APPEND );

echo json_encode( $response );

function getAnswerFromAI( $input ) {
	if ( empty( $input ) ) {
		return json_encode( 'No input given.' );
	}

	$config['open_api_key'] = configValue( 'OpenAI', 'apikey' );

	$input = preg_replace( "/\n/", ' ', $input );
	$input = preg_replace( '/ - /', ' ', $input );

	$prompt = "Mache drei plakative Formulierungen für ein grünes Wahlplakat mit folgendem Inhalt: {$input}";

	$payload = '{
        "model": "text-davinci-003",
        "prompt": "' . $prompt . '",
        "temperature": 1,
        "max_tokens": 100,
        "top_p": 1,
        "frequency_penalty": 0,
        "presence_penalty": 0,
        "stop": ["You:"]
        }';

	$ch = curl_init();

	curl_setopt( $ch, CURLOPT_URL, 'https://api.openai.com/v1/completions' );
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

	return $result_json;
}
