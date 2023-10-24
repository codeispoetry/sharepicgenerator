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
	 * The users to notify
	 *
	 * @var array
	 */
	private $users_to_notify = array();

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
		$url     = $this->api_url . 'self?limit=50';
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
	 * Adds a user to the list of users to notify the API.
	 *
	 * @param string $id The user's id.
	 * @param string $status The status: not_found or deleted.
	 * @return void
	 */
	public function add_user_to_notify( $id, $status ) {
		$this->users_to_notify[] = array(
			'id'     => $id,
			'status' => $status,
		);
	}

	/**
	 * Notifies the API about the deletion, send POST request.
	 *
	 * @return void
	 */
	public function notify() {
		$url     = $this->api_url . 'self/batch';
		$headers = array(
			'accept: */*',
			$this->auth_header,
			'Content-Type: application/json',
		);
		$data    = array(
			'upsert' => $this->users_to_notify,
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
