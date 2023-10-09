<?php
/**
 * This file is run on a frequent basis via crontab.
 * It fetches users to be deleted, deletes them and notfies the external
 * API about the deletion.
 *
 * @package Sharepicgenerator
 */

/**
 * Include the absolute path.
 */
require 'base.php';

require getBasePath( 'lib/classes/user.php' );
require getBasePath( 'lib/classes/gruene-api.php' );


$users = GrueneAPI::get_users_to_be_deleted();
foreach ( $users as $user ) {
	$status = User::delete( $user );
	GrueneAPI::notify( $user, $status );
}
