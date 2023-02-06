<?php

function do_saml_login()
{

    if (!with_saml()) {
        return 'ohne_saml';
    }

    $hasAccess = isLocal() ?: isLocalUser();

    $doLogout = false;
    if (isset($_GET['logout']) && ($_GET['logout'] == 'true')) {
        if ($hasAccess) {
            doLogout();
        } else {
            $doLogout = true;
            handleSamlAuth($doLogout);
        }
        die();
    }

    if (!$hasAccess) {
        $user = handleSamlAuth($doLogout);
    }

    return $user;
}

function getUserPrefs()
{

    $db = new SQLite3(getBasePath('log/logs/user.db'));

    $smt = $db->prepare(
        'SELECT prefs FROM user WHERE user=:user'
    );
    @$smt->bindValue(':prefs', $_POST['prefs'], SQLITE3_TEXT);
    $smt->bindValue(':user', getUser(), SQLITE3_TEXT);

    $result = $smt->execute();

    $array = $result->fetchArray();

    if (empty($array) || empty($array['prefs'])) {
        return '{}';
    }

    return $array['prefs'];
}

function getUser()
{
    if (!isset($_SESSION['user'])) {
        return false;
    }

    return $_SESSION['user'];
}

function getUserDir()
{
    $userDir = getBasePath('persistent/user/' . getUser());
    if (!file_exists($userDir)) {
        return false;
    }

    return $userDir;
}

function userHasSavedFile()
{
    global $tenant;
    return file_exists(sprintf('%s/%s_sharepic1.json', getUserDir(), $tenant));
}

function doPHPAuthenticationLogin($user, $password)
{
    if (!isset($_SERVER['PHP_AUTH_USER']) ||
        $_SERVER['PHP_AUTH_USER'] != $user ||
        $_SERVER['PHP_AUTH_PW'] != $password
    ) {
        header('WWW-Authenticate: Basic realm="Sharepicgenerator"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Zugangsdaten sind falsch!';
        exit;
    }
}
