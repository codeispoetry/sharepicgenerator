<?php
/**
 * Gruene API
 *
 * @package    Sharepicgenerator
 */

/**
 * Gruene API
 */
class GrueneAPI {
	/**
	 * The API URL
	 *
	 * @var string
	 */
	private $api_url;

	/**
	 * The auth header
	 *
	 * @var string
	 */
	private $auth_header;

	/**
	 * Read config
	 */
	public function __construct() {
		require_once getBasePath( 'lib/functions.php' );
		readConfig();

		$this->api_url     = configValue( 'GRUENE', 'api_url' );
		$this->auth_header = configValue( 'GRUENE', 'auth_header' );
	}

	/**
	 * Gets all the users to be deleted from the API.
	 */
	public function get_users_to_be_deleted() {
		$url     = $this->api_url . 'self?limit=1';
		$headers = array(
			'accept: application/json',
			$this->auth_header,
		);

		$curl = curl_init( $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );

		$response = curl_exec( $curl );
		curl_close( $curl );

		$json = json_decode( $response, false );

		return $json->data;
	}

	/**
	 * Notifies the API about the deletion
	 *
	 * @param string $id The user's id.
	 * @param string $status If the user was deleted or not_found.
	 * @return void
	 */
	public function notify( $id, $status ) {

		$url     = $this->api_url . 'self/batch';
		$headers = array(
			'accept: */*',
			$this->auth_header,
			'Content-Type: application/json',
		);
		$data    = array(
			'upsert' => array(
				array(
					'id'     => $id,
					'status' => $status,
				),
			),
		);

		$curl = curl_init( $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $curl, CURLOPT_POST, true );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode( $data ) );

		$response = curl_exec( $curl );
		curl_close( $curl );
	}
}
