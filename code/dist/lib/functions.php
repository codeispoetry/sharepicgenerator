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
    $landesverband = $_SESSION['landesverband'];
    $tenant = $_SESSION['tenant'];
    $line = sprintf("%s\t%s\t%s\t%s\t%s\n", time(), $user, $accesstoken, $msg, $landesverband, $tenant);
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
    $GLOBALS['user'] = "localuser";

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

function logPicture($filename, $format)
{
    if ($format == 'mp4') {
        return;
    }

    $afterFileBase =  getBasePath('tmp/log_' . $_SESSION['tenant'] .'_' . getUser() . '_'. time());
    
    $command = sprintf(
        "convert -resize 800x800 -background white -flatten -quality 75  %s %s",
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

function getUserFromCloudCredentials()
{
    list($user, $token) = explode(':', getCloudCredentials());
    return $user;
}

function hasCloudCredentials()
{
    $tokenfile = getUserDir() .'/.cloudcredentials.php';
    return file_exists($tokenfile);
}

function getCloudCredentials()
{
    if (hasCloudCredentials() == false) {
        return false;
    }

    require_once($tokenfile);
    return USERCLOUDCREDENTIALS;
}

function deleteCloudToken()
{
    $cloudTokenFile = getUserDir() . '/.cloudcredentials.php';
    unlink($cloudTokenFile);

    returnJsonSuccessAndDie();
}

function saveCloudToken()
{
    $cloudTokenFile = getUserDir() . '/.cloudcredentials.php';

    $credentials = sprintf('%s:%s', getUser(), $_POST['data']);
    $content = <<<EOF
<?php
define("USERCLOUDCREDENTIALS", "$credentials");

EOF;

    file_put_contents($cloudTokenFile, $content);

    // Create folder in cloud
    $credentials = sprintf('-u %s', getCloudCredentials());
    $endpoint    = sprintf(
        "MKCOL 'https://wolke.netzbegruenung.de/remote.php/dav/files/%s/sharepicgenerator'",
        getUserFromCloudCredentials()
    );
    $payload = '';
    $command = sprintf(
        'curl -X %s %s %s',
        $endpoint,
        $payload,
        $credentials
    );

    exec($command, $debug);

    returnJsonSuccessAndDie();
}

function tenantsSwitch($as)
{
    $attributes = $as->getAttributes();
    $landesverband = (int) substr($attributes['membershipOrganizationKey'][0], 1, 2);

    // if ($landesverband == 1 and isset($_SERVER['HTTP_REFERER'])) {
    //     if ('saml.gruene.de' == parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST)) {
    //         // freshly logged in
    //         header('Location: /tenants/bw', true, 302);
    //         die();
    //     }
    // }
}

function readConfig()
{
    $retval = "";
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

function showPictures($main_dir)
{
    $dirs = glob($main_dir . '/*', GLOB_ONLYDIR);
    $formats = "*.{jpg,JPG,jpeg,JPEG,png,PNG}";

    foreach ($dirs as $album) {
        $pics = glob($album . '/' . $formats, GLOB_BRACE);
        $albumname = basename($album);
        $dirname = $album;
        $photographer = "";
        $tags = "";

        $meta_file = $album . '/meta.ini';
        if (file_exists($meta_file)) {
            $meta = parse_ini_file($meta_file);
            $photographer = "<tr><td class='pr-3'>Fotograf</td><td class='llphotographer'>". $meta['Photographer'] ."</td></tr>";
            $tags = "<tr><td class='pr-3'>Tags</td><td class='lltags'>". $meta['Tags'] ."</td></tr>";
        }

        foreach ($pics as $pic) {
            $file_parts = pathinfo($pic);
            $ext = $file_parts['extension'];
            $name = $file_parts['basename'];
            $fsize = human_filesize(filesize($pic));
            $useLink = "<a href='../index.php?usePicture=pictures/".$pic ."' ><i class='fas fa-edit'></i> Verwenden</a>";

            $showPic = $pic;
            if (file_exists("$dirname/thumbs/$name")) {
                $showPic = "$dirname/thumbs/$name";
            }

            $img_data = getimagesize($pic);
            $img_size = $img_data[0] . " x " . $img_data[1];

            echo <<<EOL
          <div class="col-6 col-md-3 col-lg-1">
              <figure>
                    <img src="$showPic" class="img-fluid galleryPicture cursor-pointer" data-url="$pic"/>
                  <figcaption class="d-none">
                      <table class="small">
                          <tr>
                              <td class="pr-3">Name</td>
                              <td class="llname">$name</td>
                          </tr>
                          $photographer
                          <tr>
                              <td class="pr-3">Album</td>
                              <td class="llalbum">$albumname</td>
                          </tr>
                          <tr>
                              <td class="pr-3 llsize">Dateigröße</td>
                              <td>$fsize</td>
                          </tr>
                          <tr>
                              <td class="pr-3 llformat">Format / Größe</td>
                              <td>$ext / $img_size</td>
                          </tr>
                          $tags
                          $useLink
                      </table>
                  </figcaption>
              </figure>
          </div>
EOL;
        }
    }
}


function get_category($file_path)
{
    readConfig();
    $api_credentials = array(
    'key' => configValue('Imagga', 'key'),
    'secret' => configValue('Imagga', 'secret')
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.imagga.com/v2/uploads");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_USERPWD, $api_credentials['key'].':'.$api_credentials['secret']);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, 1);
    $fields = [
        'image' => new \CurlFile($file_path, 'image/jpeg', 'image.jpg')
    ];
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $response = curl_exec($ch);
    curl_close($ch);

    $json_response = json_decode($response);
    
    if ($json_response->status->type !== 'success') {
        return false;
    }

    $image_upload_id = $json_response->result->upload_id;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.imagga.com/v2/categories/personal_photos?language=de&image_upload_id='.$image_upload_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_USERPWD, $api_credentials['key'].':'.$api_credentials['secret']);

    $response = curl_exec($ch);
    curl_close($ch);

    $json_response = json_decode($response);
  
    if ($json_response->status->type !== 'success') {
        return false;
    }

    $return = [];
    foreach ($json_response->result->categories as $category) {
        $return[] = preg_replace('/\//', '-', $category->name->de);
    }

    return $return;
}
