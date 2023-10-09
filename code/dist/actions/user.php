<?php
require_once 'base.php';
require_once getBasePath( 'lib/functions.php' );
require_once getBasePath( 'lib/user_functions.php' );
useLocale( 'de_DE' );

session_start();

if ( ! isAllowed( true ) ) {
	die( 'not allowed' );
}

$db = new SQLite3( getBasePath( 'log/logs/user.db' ) );

$smt = $db->prepare(
	'UPDATE user SET prefs=:prefs WHERE user=:user'
);
$smt->bindValue( ':prefs', $_POST['prefs'], SQLITE3_TEXT );
$smt->bindValue( ':user', getUser(), SQLITE3_TEXT );

$smt->execute();

// echo $db->lastErrorMsg();
echo 'ok';
