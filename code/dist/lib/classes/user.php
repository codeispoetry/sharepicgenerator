<?php
/**
 * User
 *
 * @package    Sharepicgenerator
 */

/**
 * User
 */

/**
 * Static class for user getting, deleting and all that stuff
 */
class User {
	/**
	 * Public method to handle user deletion
	 *
	 * @param string $username The username.
	 * @return bool True, if user was deleted, false if user did not exist.
	 */
	public static function delete( $username ) {
		if ( preg_match( '/[^a-z0-9]/i', $username ) ) {
			return false;
		}

		$a = (bool) self::delete_in_db( $username );
		$b = (bool) self::delete_path( $username );

		$deleted = $a || $b;
		$status  = ( $deleted ) ? 'deleted' : 'not_found';

		return $status;
	}

	/**
	 * Delete files for the user.
	 *
	 * @param string $username The username.
	 * @return bool True on success, false otherwise.
	 */
	private static function delete_path( $username ) {
		$path = getBasePath( 'persistent/user/' . $username );
		if ( file_exists( $path ) === false ) {
			return false;
		}

		system( 'rm -rf ' . $path );
		return true;
	}

	/**
	 * Deletes the user from the database.
	 *
	 * @param string $username The username.
	 * @return bool True on success, false otherwise.
	 */
	private static function delete_in_db( $username ) {

		$db = new SQLite3( getBasePath( 'log/logs/user.db' ) );

		$smt = $db->prepare(
			'DELETE FROM user WHERE user=:user'
		);
		$smt->bindValue( ':user', $username, SQLITE3_TEXT );

		$smt->execute();

		return $db->changes();
	}
}
