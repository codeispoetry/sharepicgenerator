<?php

function useDeLocale()
{
    setlocale(LC_ALL, ' de_DE.UTF-8', 'de_DE.utf8');
}

function createAccessToken($user)
{
    $userDir = getBasePath('persistent/user/' . $user);

    if (!file_exists($userDir)) {
        mkdir($userDir);
    }

    $accesstoken = uniqid();
    $content = <<<EOF
<?php
define("ACCESSTOKEN", "$accesstoken");

EOF;

    file_put_contents(sprintf('%s/accesstoken.php', $userDir), $content);

    saveLastLogin($user);

    return $accesstoken;
}

function saveLastLogin($user)
{
    $db = new SQLite3(getBasePath('log/logs/user.db'));
    if (isAdmin()) {
        $db->exec('CREATE TABLE IF NOT EXISTS user(
            user TEXT PRIMARY KEY,
            last_login DATETIME,
            prefs TEXT)');
    }

    if (getLastLogin($user) === false) {
        $sql = 'INSERT INTO user (user,last_login) values (:user,datetime())';
    } else {
        $sql = 'UPDATE user SET last_login=datetime() WHERE user=:user';
    }

    $smt = $db->prepare($sql);
    $smt->bindValue(':user', $user, SQLITE3_TEXT);
    $smt->execute();
}

function getLastLogin($user = false)
{
    if (!$user) {
        $user = getUser();
    }
    $db = new SQLite3(getBasePath('log/logs/user.db'));
    $smt = $db->prepare(
        'SELECT last_login, cast(julianday("now") - julianday(last_login) as int) as days FROM user WHERE user=:user'
    );
    $smt->bindValue(':user', $user, SQLITE3_TEXT);
    
    $result = $smt->execute();
 
    $array = $result->fetchArray();

    if (empty($array)) {
        return false;
    }

    $timestamp = strToTime($array['last_login']);
   
    switch ($array['days']) {
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
            if ($array['days'] <7) {
                $day = strftime('letzten %A', $timestamp);
            }else{
                $day = strftime('am %e. %B', $timestamp);
            }
            break;
    }
    
    return $day . ' ' .strftime('um %R Uhr', $timestamp);
}


function isAllowed($with_csrf = false)
{
    if (!isset($_SESSION['accesstoken'])) {
        logFailure('no session access token');
        return false;
    }

    $accesstoken = $_SESSION['accesstoken'];
    $user = getUser();

    if ($user == false) {
        return false;
    }

    if (checkPermission($user, $accesstoken) == false) {
        logFailure('permission denied with ' . $user . ':' .$accesstoken);
        return false;
    }

    if ($with_csrf == true) {
        if (($_POST['csrf'] == '') || ($_POST['csrf'] != $_SESSION['csrf'])) {
            logFailure('csrf missmatch');
            return false;
        }
    }

    return true;
}

function checkPermission($user, $accesstoken)
{
    $userDir = getBasePath('persistent/user/' . $user);

    if (!file_exists($userDir)) {
        logFailure('no userDir for ' . $user);
        return false;
    }

    require_once(sprintf('%s/accesstoken.php', $userDir));
    if ($accesstoken != ACCESSTOKEN) {
        logFailure('accesstoken for ' . $user . ' is ' . $accesstoken . ' and should be ' . ACCESSTOKEN);
    }
    return $accesstoken == ACCESSTOKEN;
}

function isAdmin()
{
    $admins = explode(",", configValue("Main", "admins"));
    return in_array(getUser(), $admins);
}

function isEditor()
{
    global $tenant;

    $editors = explode(",", configValue($tenant, "editors"));
    return in_array(getUser(), $editors);
}

function getUser()
{
    if (!isset($_SESSION['user'])) {
        logFailure('no session user');
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

function returnJsonErrorAndDie($code = 1)
{
    echo json_encode(array('success'=>'false','error'=>array('code'=>$code)));
    die();
}

function returnJsonSuccessAndDie()
{
    echo json_encode(array('success'=>'true'));
    die();
}

function logFailure($msg)
{
    $accesstoken = $_SESSION['accesstoken'];
    $user = $_SESSION['user'];
    $chapter = $_SESSION['chapter'];
    $tenant = $_SESSION['tenant'];
    $line = sprintf("%s\t%s\t%s\t%s\t%s\n", time(), $user, $accesstoken, $msg, $chapter, $tenant);
    file_put_contents(getBasePath('log/logs/error.log'), $line, FILE_APPEND);
}

function logDownload()
{
    $sharepic = $_POST['sharepic'];
    $config = $_POST['config'];
  
    parse_str($sharepic, $data);
    $data = array_merge(json_decode($config, true), $data);
    unset($data['pixabay']);
    unset($data['csrf']);

    // rewrite username to user
    $data['user'] = $data['username'];
    unset($data['username']);

    if ($data['eraser']) {
        $data['eraser'] = 'true';
    };


    $db = new SQLite3(getBasePath('log/logs/log.db'));
    $columns = [];
    $results = $db->query("PRAGMA table_info('downloads');");
    while ($row = $results->fetchArray()) {
        if ($row['name'] === 'timestamp') {
            continue;
        }
        $columns[] = $row['name'];
    }

    if (isAdmin()) {
        $db->exec('CREATE TABLE IF NOT EXISTS downloads(
                id INTEGER PRIMARY KEY AUTOINCREMENT, 
                timestamp DATETIME DEFAULT CURRENT_TIMESTAMP)');

        // add missing columns
        $newColumns = array_diff(array_keys($data), $columns);
        foreach ($newColumns as $newColumn) {
            $type = 'TEXT';
            if (in_array($newColumn, ['uploadTime','createTime'])) {
                $type = 'INTEGER';
            }
            $db->exec("ALTER TABLE downloads ADD $newColumn $type");
            $columns[] = $newColumn;
        }
    }
    
    // do logging into download
    $smt = $db->prepare(
        sprintf(
            'INSERT INTO downloads (%s) values (:%s)',
            join(',', $columns),
            join(',:', $columns)
        )
    );
    foreach ($data as $variable => $value) {
        $smt->bindValue(':'.$variable, $value, SQLITE3_TEXT);
    }
    $smt->execute();
}

function isLocal()
{
    $GLOBALS['user'] = "localaccessed";
    return ($_SERVER['REMOTE_ADDR'] == '127.0.0.1');
}

function isLocalUser()
{
    $localuser = 'localuser';
    
    $GLOBALS['user'] = $localuser;
    if(getUser() === $localuser and isAllowed()){
        return true;
    }

    if (!isset($_POST['pass'])) {
        return false;
    }

    if (!file_exists(getBasePath('ini/passwords.php'))) {
        return false;
    }

    if (!loginAttemptsLeft()) {
        die("Bitte warten. Zu viele Fehlversuche.");
    }

    require_once(getBasePath('ini/passwords.php'));
    if (in_array($_POST['pass'], $passwords)) {
        return true;
    }

    increaseLoginAttempts();

    die("Passwort falsch");
    return false;
}

function increaseLoginAttempts()
{
    $file = getBasePath('loginattempts.txt');

    if (file_exists($file)) {
        $attempts = file_get_contents($file);
        $attempts++;
    } else {
        $attempts = 1;
    }

    file_put_contents($file, $attempts);
}

function loginAttemptsLeft()
{
    $file = getBasePath('loginattempts.txt');

    if (!file_exists($file)) {
        return true;
    }

    if (time() - filemtime($file) > 5 * 60) {
        unlink($file);
        return true;
    }

    $attempts = file_get_contents($file);

    if ($attempts < 5) {
        return true;
    }

    return false;
}

function isDaysBefore($dayMonth, $days = 14)
{
    $day = new DateTime(sprintf('%s%d 23:59:59', $dayMonth, date('Y'))); // tag.monat.jahr
    $today = new DateTime();
    $interval = $day->diff($today);

    return ($interval->days < $days and $interval->invert == 1);
}

function doLogout() {
    session_destroy( );
    header("Location: /");
    die();

}

function handleSamlAuth($doLogout = false)
{
    $samlfile = '/var/simplesaml/lib/_autoload.php';
    $host = configValue("Main", "host");
    $logoutTarget = configValue("Main", "logoutTarget");
    $userAttr = configValue("SAML", "userAttr");

    if ($_SERVER['HTTP_HOST'] == $host and file_exists($samlfile)) {
        require_once($samlfile);
        $as = new SimpleSAML_Auth_Simple('default-sp');
        $as->requireAuth();

        if ($doLogout == true) {
            header("Location: ".$as->getLogoutURL($logoutTarget));
            die();
        }

        $samlattributes = $as->getAttributes();
        $user = $samlattributes[$userAttr][0];

        $session = SimpleSAML_Session::getSessionFromRequest();
        $session->cleanup();
    
        if (configValue("SAML", "doTenantsSwitch")) {
            tenantsSwitch($as);
        }
    } else {
        $user = "nosamlfile";
    }

    return $user;
}

function sanitizeUserInput($var)
{
    return preg_replace('/[^a-zA-Z0-9\._]/', '', $var);
}

function timecode2seconds($timecode)
{
    $parts = explode(":", $timecode);
    $parts = array_reverse($parts);
    $seconds = 0;
    $multiplier = 1;

    foreach ($parts as $part) {
        $seconds += $part * $multiplier;
        $multiplier *= 60;
    }

    return $seconds;
}

function convert($filename, $width, $format, $quality = 75)
{
    if ($format == 'pdf') {
        $tempformat = 'pdf';
    } else {
        $tempformat = 'png';
    }

    $command = sprintf(
        "inkscape %s --export-width=%d --export-{$tempformat}=%s --export-dpi=90",
        $filename,
        $width,
        getBasePath('tmp/' . basename($filename, 'svg') . $tempformat)
    );
    exec($command);

    if ($format == 'jpg') {
        $command = sprintf(
            "convert %s -background white -flatten -quality %s %s",
            getBasePath('tmp/' . basename($filename, 'svg') . $tempformat),
            $quality,
            getBasePath('tmp/' . basename($filename, 'svg') . $format)
        );
        exec($command);
    }

    if ($format == 'mp4') {
        $command =sprintf(
            'ffmpeg -i %s -i %s -filter_complex "[0:v][1:v] overlay=0:0" -b:v 2M -pix_fmt yuv420p -c:a copy %s 2>%s',
            getBasePath('tmp/'. basename($_POST['videofile'])),
            getBasePath('tmp/' . basename($filename, 'svg') . 'png'),
            getBasePath('tmp/' . basename($filename, 'svg') . 'mp4'),
            getBasePath('tmp/' . basename($_POST['videofile'], 'mp4') . 'log')
        );
        exec($command);
    }
}

function logPicture($filename, $format)
{
    if ($format == 'mp4') {
        return;
    }

    $afterFileBase =  getBasePath('tmp/log_' . $_SESSION['tenant'] .'_' . getUser() . '_'. $filename);
    
    $command = sprintf(
        "convert -resize 800x800 -background white -flatten -quality 60  %s %s",
        getBasePath('tmp/' . $filename . '.png'),
        $afterFileBase . '.jpg'
    );
    exec($command);
}

function debug($msg)
{
    file_put_contents(getBasePath('log/logs/error.log'), $msg, FILE_APPEND);
}

function debugPic($filename, $format)
{
    $get = http_build_query($_GET, '', ', ');
    $file = getBasePath('tmp/' . $filename . '.' . $format);

    if (file_exists($file)) {
        $size = filesize($file);
    } else {
        $size = -1;
    }
    $debugTxt = sprintf("%s\t%s\t%s\t%s\n", time(), $filename, $size, $get);
    debug($debugTxt);
}

function deleteUserLogo($file)
{
    $userDir = getBasePath('persistent/user/' . getUser());

    if (!file_exists($userDir)) {
        returnJsonErrorAndDie('not allowed');
    }

    $file = $userDir . '/' . basename($file);

    if (!file_exists($file)) {
        returnJsonErrorAndDie('logo not found');
    }
    unlink($file);

    returnJsonSuccessAndDie();
}

function deleteFont($file)
{
    foreach(array('woff2','ttf') AS $extension){
        $userFile = getBasePath('persistent/fonts/') . $file . '.' . $extension;
        unlink($userFile);
    }

    returnJsonSuccessAndDie();
}

function xml2json($xml)
{
    $xml = preg_replace('/d\:/', '', $xml);

    $xml = simplexml_load_string($xml);
    $json = json_encode($xml);
    $array = json_decode($json, false);

    if (is_null($array->response)) {
        echo json_encode(
            array(
                "status" => 502,
                "data" => "Access denied"
            )
        );
        die();
    }

    if (!is_array($array->response)) {
        return array();
    }

    // the first item is the directory, skip it
    array_shift($array->response);

    $return = array();
    foreach ($array->response as $file) {
        if (strToLower(pathinfo($file->href, PATHINFO_EXTENSION)) == 'zip') {
            $return[] = $file->href;
        }
    }

    return $return;
}


function tenantsSwitch($as)
{
    $attributes = $as->getAttributes();
    $chapter = (int) substr($attributes['membershipOrganizationKey'][0], 1, 2);

    // freshly logged in
    if (isset($_SERVER['HTTP_REFERER']) && 'saml.gruene.de' == parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST)) {
        switch ($chapter) {
            case 10:
                $tenant = '/nrw/';
                break;
            case 15:
                $tenant = '/sh/';
                break;
            default:
                $tenant = false;
        }
    }
        
    // redirect, if s.o. is freshly logged in and wants to to to standard btw21
    if ($tenant && $_SERVER['REQUEST_URI'] === '/btw21/' && $_SERVER['REQUEST_URI'] != $tenant) {
        header('Location: ' . $tenant, true, 302);
        die();
    }
        
}

function readConfig()
{
    $config_file = getBasePath('/ini/config.ini');

    if (file_exists($config_file)) {
        $_SESSION['config'] = parse_ini_file($config_file, true);
    }
}

function configValue($group, $attribute)
{
    $value = false;
    if (isset($_SESSION["config"][$group][$attribute])) {
        $value = $_SESSION["config"][$group][$attribute];
    }
    return $value;
}

function pixabayConfig()
{
    $apikey = configValue("Pixabay", "apikey");
    if ($apikey != false) {
        $retval = "config.pixabay={ 'apikey': '". $apikey . "' };";
    }
    return $retval;
}

function reuseSavework($saveworkFile)
{
    $tmpdir = 'tmp/' . uniqid('work');
    $savedir = getBasePath($tmpdir);

    $cmd = sprintf('unzip %s -d %s 2>&1', $saveworkFile, $savedir);
    exec($cmd, $output);

    $cmd = sprintf("chmod -R 777 %s", $savedir);
    exec($cmd, $output);

    $return['okay'] = true;
    $datafile = $savedir . '/data.json';
    $json = file_get_contents($datafile);

    $return['data'] = $json;
    $return['dir'] = '../'. $tmpdir;

    return json_encode($return);
}

function human_filesize($bytes, $decimals = 2)
{
    $factor = floor((strlen($bytes) - 1) / 3);
    if ($factor > 0) {
        $sz = 'KMGT';
    }
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
}


function getSaying($field = 'main'){
    static $rand;
    $sayings = parse_ini_file(getBasePath('ini/sayings.ini'), true);
    if(!$rand) {
        $rand = array_rand($sayings, 1);
    }

    return $sayings[$rand][$field];
}


function getFontFamily($file){

    if(is_file($file)){
        return false;
    }

    $cmd = sprintf("fc-list : family file | grep %s | sed 's/.*: //g'", $file);
    exec($cmd, $output);

    return $output[0];

}

function isGuest(){
    return getUser() == 'guest';
}

function latestVersion($file){
    printf('%s?v=%s', $file, filemtime(getBasePath($file)));
}


function displayDevelopHint()
{
    if (configValue('Main', 'develop')) {
        echo "<div><em>Du befindest Dich auf dem Testserver.</em></div>";
    }
}
