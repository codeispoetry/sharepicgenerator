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
	 * Gets all the users to be deleted from the API.
	 */
	public static function get_users_to_be_deleted() {
		$usernames = array(
			'foo',
			'bar',
		);
		return $usernames;
	}

	/**
	 * Notifies the API about the deletion
	 *
	 * @param string $username The Username.
	 * @param string $status If the user was deleted or not_found.
	 * @return void
	 */
	public static function notify( $username, $status ) {
		echo "$username $status \n";

	}
}
