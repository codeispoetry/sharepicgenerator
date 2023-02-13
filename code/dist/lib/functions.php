<?php

function useLocale($locale)
{
    putenv('LC_ALL=' . $locale);
    setlocale(LC_ALL, $locale);

    bindtextdomain('sharepicgenerator', getBasePath('language'));
    bind_textdomain_codeset('sharepicgenerator', 'UTF-8');
    textdomain("sharepicgenerator");
}

function _e($text)
{
    echo gettext($text);
}

function __(string $text): string
{
    return gettext($text);
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

function isLocal()
{
    $GLOBALS['user'] = "localaccessed";
    return ($_SERVER['REMOTE_ADDR'] == '127.0.0.1');
}

function with_saml()
{
    return file_exists(getBasePath('scripts/status/saml_is_up'));
}

function sanitizeUserInput($var)
{
    return preg_replace('/[^a-zA-Z0-9\._]/', '', $var);
}

function convert($filename, $width)
{
    $command = sprintf(
        "inkscape %s --export-width=%d --export-png=%s --export-dpi=90",
        $filename,
        $width,
        getBasePath('tmp/' . basename($filename, 'svg') . 'png')
    );
    exec($command);
}

function logPicture($filename)
{
    $afterFileBase =  getBasePath('tmp/log_' . $_SESSION['tenant'] .'_' . getUser() . '_'. $filename);
    
    $command = sprintf(
        "convert -resize 800x800 -background white -flatten -quality 60  %s %s",
        getBasePath('tmp/' . $filename . '.png'),
        $afterFileBase . '.jpg'
    );
    exec($command);
}

function readConfig()
{
    $config_file = getBasePath('/ini/config.ini');

    if (file_exists($config_file)) {
        $_SESSION['config'] = parse_ini_file($config_file, true);
    }
}

function configValue($group, $attribute, $default = false)
{
    $value = false;
    if (isset($_SESSION["config"][$group][$attribute])) {
        $value = $_SESSION["config"][$group][$attribute];
    }

    return $value ?: $default;
}

function getColorAtIndex($index = false)
{
    global $tenant;
    if (!isset($_SESSION["config"][$tenant]['colors'])) {
        echo '#ff0000';
        return;
    }

    if (is_numeric($index)) {
        echo explode(',', $_SESSION["config"][$tenant]['colors'])[$index];
        return;
    }

    echo $_SESSION["config"][$tenant]['colors'];
}

function getDefaultLogo()
{
    global $tenant;
    return sprintf('/assets/%s/logo.svg', $tenant);
}

function pixabayConfig()
{
    $apikey = configValue("Pixabay", "apikey");
    if ($apikey != false) {
        $retval = "config.pixabay={ 'apikey': '". $apikey . "' };";
    }
    return $retval;
}

function isGuest()
{
    return getUser() == 'guest';
}

function latestVersion($file)
{
        printf('%s?v=%s', $file, filemtime(getBasePath($file)));
}
