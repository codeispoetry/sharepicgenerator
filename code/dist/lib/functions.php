<?php

function useDeLocale()
{
    setlocale(LC_ALL, ' de_DE.UTF-8', 'de_DE.utf8');
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
        logFailure('permissions denied');
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
        return false;
    }

    require_once(sprintf('%s/accesstoken.php', $userDir));
    return $accesstoken == ACCESSTOKEN;
}

function getUser()
{
    if (!isset($_SESSION['user'])) {
        logFailure('no session user');
        return false;
    }

    return $_SESSION['user'];
}

function getCloudCredentials()
{
    $tokenfile = getUserDir() .'/.cloudcredentials.txt';

    if (!file_exists($tokenfile)) {
        return false;
    }
    return file_get_contents($tokenfile);
}

function getUserFromCloudCredentials()
{
    list($user, $token) = explode(':', getCloudCredentials());
    return $user;
}

function getUserDir()
{
    $userDir = getBasePath('persistent/user/' . getUser());
    if (!file_exists($userDir)) {
        return false;
    }

    return $userDir;
}

function hasCloudCredentials()
{
    $user = getUser();
    $cloudTokenFile = getBasePath(sprintf('persistent/user/%s/.cloudcredentials.txt', $user));
    return file_exists($cloudTokenFile);
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
    $accesstoken = $_SESSION['accestoken'];
    $user = $_SESSION['user'];
    $landesverband = $_SESSION['landesverband'];
    $tenant = $_SESSION['tenant'];
    $line = sprintf("%s\t%s\t%s\t%s\t%s\n", time(), $user, $accesstoken, $msg, $landesverband, $tenant);
    file_put_contents(getBasePath('log/error.log'), $line, FILE_APPEND);
}

function logLogin()
{
    $user = $_SESSION['user'];
    $landesverband = $_SESSION['landesverband'];
    $tenant = $_SESSION['tenant'];
    $line = sprintf("%s\t%s\t%s\t%s\t%s\n", time(), $user, "login", $landesverband, $tenant);
    file_put_contents(getBasePath('log/log.log'), $line, FILE_APPEND);
}

function logDownload()
{
    $user = $_SESSION['user'];
    $pixabay = sanitizeUserinput($_POST['usepixabay']);
    $socialmediaplatform = sanitizeUserinput($_POST['socialmediaplatform']);
    $line = sprintf("%s\t%s\t%s\t%s\t%s\n", time(), $user, 'download', $pixabay, $socialmediaplatform);
    file_put_contents(getBasePath('log/log.log'), $line, FILE_APPEND);
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
    return $accesstoken;
}

function isLocal()
{
    $GLOBALS['user'] = "localaccessed";
    return ($_SERVER['REMOTE_ADDR'] == '127.0.0.1');
}

function isLocalUser()
{
    $GLOBALS['user'] = "localuser";

    if (!isset($_POST['pass'])) {
        return false;
    }

    if (!file_exists(getBasePath('passwords.php'))) {
        return false;
    }

    if (!loginAttemptsLeft()) {
        die("Bitte warten. Zu viele Fehlversuche.");
    }

    require_once(getBasePath('passwords.php'));
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

function handleSamlAuth()
{
    $samlfile = '/var/simplesaml/lib/_autoload.php';
    if (file_exists($samlfile)) {
        require_once($samlfile);
        $as = new SimpleSAML_Auth_Simple('default-sp');
        $as->requireAuth();
        $samlattributes = $as->getAttributes();
        $user = $samlattributes['urn:oid:0.9.2342.19200300.100.1.1'][0];
        require_once('./inc/versionswitch.php');
    } else {
        $user = "nosamlfile";
    }

    return $user;
}

function sanitizeUserInput($var)
{
    return preg_replace('/[^a-zA-Z0-9\.]/', '', $var);
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

        if ($_POST['ismosaic'] == "true") {
            $dir = getBasePath('tmp/' . basename($filename, '.svg'));

            $command = sprintf('mkdir %s', $dir);
            exec($command);

            copy('mosaik_readme.txt', sprintf('%s/z_anleitung.txt', $dir));

            $command = sprintf(
                'convert %s -crop 3x3@ +repage +adjoin -scene 1 %s/bild_%%d.jpg',
                getBasePath('tmp/' . basename($filename, 'svg') . $format),
                $dir
            );
            exec($command);

            $command = sprintf("montage %s/bild*.jpg -geometry 200x200+8+8 %s/gesamt.jpg", $dir, $dir);
            exec($command);


            $command = sprintf('zip -j %s.zip %s/*', $dir, $dir);
            exec($command);
        }
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

function tidyUp($filename, $format)
{
    if ($format == 'mp4') {
        return;
    }

    $command = sprintf(
        "convert -resize 500x500 -background white -flatten -quality 60  %s %s",
        getBasePath('tmp/' . $filename . '.png'),
        getBasePath('tmp/log' . time() . '_' . $filename . '.jpg')
    );
    exec($command);

    //unlink(getBasePath('tmp/' . $filename . '.' . $format));
    //unlink(getBasePath('tmp/' . $filename . '.svg'));
    //unlink(getBasePath('tmp/' . $filename . '.png'));
}

function debug($filename, $format)
{
    $get = http_build_query($_GET, '', ', ');
    $file = getBasePath('tmp/' . $filename . '.' . $format);

    if (file_exists($file)) {
        $size = filesize($file);
    } else {
        $size = -1;
    }

    $debug = sprintf("%s\t%s\t%s\t%s\n", time(), $filename, $size, $get);
    file_put_contents(getBasePath('log/error.log'), $debug, FILE_APPEND);
}

function deleteUserLogo($user)
{
    $userDir = getBasePath('persistent/user/' . $user);

    if (!file_exists($userDir)) {
        returnJsonErrorAndDie('not allowed');
    }

    $logos = glob(sprintf('%s/logo.*', $userDir));

    array_walk($logos, function (&$file) {
        unlink($file);
    });

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
