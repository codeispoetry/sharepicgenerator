<?php

function do_saml_login() {
	if ( ! with_saml() ) {
		global $province;
		$province       = new stdClass();
		$province->key  = 1;
		$province->name = 'Baden-Württemberg';
		return 'ohnesaml';
	}

	$user      = 'guest';
	$hasAccess = isLocal() ?: isLocalUser();

	$doLogout = false;
	if ( isset( $_GET['logout'] ) && ( $_GET['logout'] == 'true' ) ) {
		if ( $hasAccess ) {
			doLogout();
		} else {
			$doLogout = true;
			handleSamlAuth( $doLogout );
		}
		die();
	}

	if ( ! $hasAccess ) {
		$user = strToLower( handleSamlAuth( $doLogout ) );
	}

	return $user;
}

function handleSamlAuth( $doLogout = false ) {
	global $province;
	$samlfile     = '/var/simplesaml/lib/_autoload.php';
	$host         = configValue( 'Main', 'host' );
	$logoutTarget = configValue( 'Main', 'logoutTarget' );
	$userAttr     = configValue( 'SAML', 'userAttr' );

	if ( $_SERVER['HTTP_HOST'] == $host and file_exists( $samlfile ) ) {
		require_once $samlfile;
		$as = new SimpleSAML_Auth_Simple( 'default-sp' );
		$as->requireAuth();

		if ( $doLogout == true ) {
			header( 'Location: ' . $as->getLogoutURL( $logoutTarget ) );
			die();
		}

		$samlattributes = $as->getAttributes();

		$province       = new stdClass();
		$province->key  = (int) substr( $samlattributes['membershipOrganizationKey'][0], 1, 3 );
		$province->name = getProvince( $samlattributes['membershipOrganizationKey'][0] );
		$user           = $samlattributes[ $userAttr ][0];

		$session = SimpleSAML_Session::getSessionFromRequest();
		$session->cleanup();
	} else {
		$user = 'nosamlfile';
	}

	return $user;
}

function getProvince( $membershipOrganizationKey ) {
	$provinces = array(
		'101' => 'Baden-Württemberg',
		'102' => 'Bayern',
		'103' => 'Berlin',
		'104' => 'Bremen',
		'105' => 'Brandenburg',
		'106' => 'Hamburg',
		'107' => 'Hessen',
		'108' => 'Mecklenburg-Vorpommern',
		'109' => 'Niedersachsen',
		'110' => 'Nordrhein-Westfalen',
		'111' => 'Rheinland-Pfalz',
		'112' => 'Saarland',
		'113' => 'Sachsen',
		'114' => 'Sachsen-Anhalt',
		'115' => 'Schleswig',
		'116' => 'Thüringen',
	);

	$key = substr( $membershipOrganizationKey, 0, 3 );

	return $provinces[ $key ] ?? 'Deutschland';
}

function getUserPrefs() {
	$db = new SQLite3( getBasePath( 'log/logs/user.db' ) );

	$smt = $db->prepare(
		'SELECT prefs FROM user WHERE user=:user'
	);
	@$smt->bindValue( ':prefs', $_POST['prefs'], SQLITE3_TEXT );
	$smt->bindValue( ':user', getUser(), SQLITE3_TEXT );

	$result = $smt->execute();

	$array = $result->fetchArray();

	if ( empty( $array ) || empty( $array['prefs'] ) ) {
		return '{}';
	}

	return $array['prefs'];
}

function getUser() {
	if ( ! isset( $_SESSION['user'] ) ) {
		return false;
	}

	return $_SESSION['user'];
}

function getUserDir() {
	 $userDir = getBasePath( 'persistent/user/' . getUser() );
	if ( ! file_exists( $userDir ) ) {
		return false;
	}

	return $userDir;
}

function userHasSavedFile() {
	global $tenant;
	return file_exists( sprintf( '%s/%s_sharepic1.json', getUserDir(), $tenant ) );
}

function doPHPAuthenticationLogin( $user, $password ) {
	if ( ! isset( $_SERVER['PHP_AUTH_USER'] ) ||
		$_SERVER['PHP_AUTH_USER'] != $user ||
		$_SERVER['PHP_AUTH_PW'] != $password
	) {
		header( 'WWW-Authenticate: Basic realm="Sharepicgenerator"' );
		header( 'HTTP/1.0 401 Unauthorized' );
		echo 'Zugangsdaten sind falsch!';
		exit;
	}
}

function increaseLoginAttempts() {
	$file = getBasePath( 'loginattempts.txt' );

	if ( file_exists( $file ) ) {
		$attempts = file_get_contents( $file );
		$attempts++;
	} else {
		$attempts = 1;
	}

	file_put_contents( $file, $attempts );
}

function loginAttemptsLeft() {
	$file = getBasePath( 'loginattempts.txt' );

	if ( ! file_exists( $file ) ) {
		return true;
	}

	if ( time() - filemtime( $file ) > 5 * 60 ) {
		unlink( $file );
		return true;
	}

	$attempts = file_get_contents( $file );

	if ( $attempts < 5 ) {
		return true;
	}

	return false;
}

function doLogout() {
	session_destroy();
	header( 'Location: /' );
	die();
}

function isLocalUser() {
	$localuser = 'localuser';

	$GLOBALS['user'] = $localuser;
	if ( getUser() === $localuser and isAllowed() ) {
		return true;
	}

	if ( ! isset( $_REQUEST['pass'] ) ) {
		return false;
	}

	if ( ! file_exists( getBasePath( 'ini/passwords.php' ) ) ) {
		return false;
	}

	if ( ! loginAttemptsLeft() ) {
		die( 'Bitte warten. Zu viele Fehlversuche.' );
	}

	require_once getBasePath( 'ini/passwords.php' );
	if ( in_array( $_REQUEST['pass'], $passwords ) ) {
		return true;
	}

	increaseLoginAttempts();

	die( 'Passwort falsch' );
	return false;
}

function isAdmin() {
	$admins = explode( ',', configValue( 'Main', 'admins' ) );
	return in_array( getUser(), $admins );
}

function isEditor() {
	global $tenant;

	$editors = explode( ',', configValue( $tenant, 'editors' ) );
	return in_array( getUser(), $editors );
}


function checkPermission( $user, $accesstoken ) {
	$userDir = getBasePath( 'persistent/user/' . $user );

	if ( ! file_exists( $userDir ) ) {
		return false;
	}

	require_once sprintf( '%s/accesstoken.php', $userDir );
	return $accesstoken == ACCESSTOKEN;
}

function getLastLogin( $user = false ) {
	if ( ! $user ) {
		$user = getUser();
	}
	try {
		$db = new SQLite3( getBasePath( 'log/logs/user.db' ) );
	} catch ( Exception $e ) {
		return false;
	}
	try {
		$smt = $db->prepare(
			'SELECT last_login, cast(julianday("now") - julianday(last_login) as int) as days FROM user WHERE user=:user'
		);
	} catch ( Exception $e ) {
		return false;
	}

	$smt->bindValue( ':user', $user, SQLITE3_TEXT );

	$result = $smt->execute();

	$array = $result->fetchArray();

	if ( empty( $array ) ) {
		return false;
	}

	$timestamp = strToTime( $array['last_login'] );

	switch ( $array['days'] ) {
		case 0:
			$day = 'heute';
			break;
		case 1:
			$day = 'gestern';
			break;
		case 2:
			$day = 'vorgestern';
			break;
		default:
			if ( $array['days'] < 7 ) {
				$day = 'letzten' . date( 'D', $timestamp );
			} else {
				$day = 'am ' . date( 'd. m.', $timestamp );
			}
			break;
	}

	return $day . ' um ' . date( 'H:M ', $timestamp ) . 'Uhr';
}


function isAllowed( $with_csrf = false ) {
	if ( ! with_saml() ) {
		return true;
	}

	if ( ! isset( $_SESSION['accesstoken'] ) ) {
		return false;
	}

	$accesstoken = $_SESSION['accesstoken'];
	$user        = getUser();

	if ( $user == false ) {
		return false;
	}

	if ( checkPermission( $user, $accesstoken ) == false ) {
		return false;
	}

	if ( $with_csrf == true ) {
		if ( ( $_POST['csrf'] == '' ) || ( $_POST['csrf'] != $_SESSION['csrf'] ) ) {
			return false;
		}
	}

	return true;
}

function createAccessToken( $user ) {
	$userDir = getBasePath( 'persistent/user/' . $user );

	if ( ! file_exists( $userDir ) ) {
		mkdir( $userDir );
	}

	$accesstoken = uniqid();
	$content     = <<<EOF
<?php
define("ACCESSTOKEN", "$accesstoken");

EOF;

	file_put_contents( sprintf( '%s/accesstoken.php', $userDir ), $content );

	saveLastLogin( $user );

	return $accesstoken;
}

function saveLastLogin( $user ) {
	$db = new SQLite3( getBasePath( 'log/logs/user.db' ) );
	if ( isAdmin() ) {
		$db->exec(
			'CREATE TABLE IF NOT EXISTS user(
            user TEXT PRIMARY KEY,
            last_login DATETIME,
            prefs TEXT)'
		);
	}

	if ( getLastLogin( $user ) === false ) {
		$sql = 'INSERT INTO user (user,last_login) values (:user,datetime())';
	} else {
		$sql = 'UPDATE user SET last_login=datetime() WHERE user=:user';
	}

	$smt = $db->prepare( $sql );
	$smt->bindValue( ':user', $user, SQLITE3_TEXT );
	$smt->execute();
}
