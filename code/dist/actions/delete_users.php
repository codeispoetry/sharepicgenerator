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

$gruene_api = new GrueneAPI();
$users      = $gruene_api->get_users_to_be_deleted();

foreach ( $users as $user ) {
	printf( 'Deleting user %s (%s)<br>' . PHP_EOL, $user->username, $user->id );
	$status = User::delete( $user->username );
	$gruene_api->notify( $user->id, $status );
}
