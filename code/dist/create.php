<?php
$samlfile = '/var/simplesaml/lib/_autoload.php';
$landesverband = 0;
$user = "generic";

$hasAccess = isLocal() ?: isLocalUser();

if( !$hasAccess ){
    if (file_exists($samlfile)) {
        require_once($samlfile);
        $as = new SimpleSAML_Auth_Simple('default-sp');
        $as->requireAuth();
        $samlattributes = $as->getAttributes();
        $user = $samlattributes['urn:oid:0.9.2342.19200300.100.1.1'][0];

        require_once('inc/versionswitch.php');
    }else {
        $user = "nosamlfile";
    }
}

if (file_exists('log/do.php')){
    require_once('log/do.php');
}

function isLocalUser(){
    $GLOBALS['user'] = "localuser";
    if( !isset($_POST['pass'])){
        return false;
    }

    if( !file_exists('passwords.php')){
        return false;
    }

    require_once('passwords.php');
    if( in_array($_POST['pass'], $passwords)){
        return true;
    }

    die("Passwort falsch");
    return false;
}

function isLocal(){
    $GLOBALS['user'] = "localaccessed";
    return ($_SERVER['REMOTE_ADDR'] == '127.0.0.1');
}

$accessToken = createAccessToken( $user );
function createAccessToken( $user ){
    $userDir = 'persistent/user/' . $user;
    if( !file_exists($userDir)){
        return '0';
    }

    $accessToken = uniqid();
    file_put_contents( sprintf('%s/accesstoken.php',$userDir), $accessToken);
    return $accessToken;
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="theme-color" content="#46962b">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sharepicgenerator</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="./vendor/bootstrap4-toggle.min.css">
    <link rel="apple-touch-icon" sizes="57x57" href="favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#46962b">
    <meta name="msapplication-TileImage" content="favicons/ms-icon-144x144.png">

</head>
<body>
<div class="container-fluid">
    <div class="row">
       
        <div class="col-12 col-lg-9">
            <div class="col-12 text-center pt-4 pb-3">
                <h1 class="text-uppercase h6"><a href="index.php" class="text-body">Sharepicgenerator</a></h1>
            </div>
            <div class="col-12">
                <div id="canvas"></div>
            </div>
            <div class="col-12 mt-3 mb-3">
                <div id="message" class="bg-danger text-white p-4" style="display:none"></div>
            </div>

            <div class="col-12 text-center mb-5">
                <button class="btn btn-secondary btn-lg" id="download">
                    <i class="fas fa-download"></i> Herunterladen
                </button>
            </div>


            <div class="col-12 text-center mb-5">
                <a href="/vintage" class="btn btn-outline-info btn-sm">
                    <i class="fab fa-pied-piper-alt"></i> Vintage-Version zum 30./40. Geburtstag
                </a>
            </div>


        </div>
        <div class="col-12 col-lg-3 mt-3 mb-5 cockpit">
            <?php require_once('inc/cockpit.php'); ?>
        </div>
    </div>
</div>

<footer class="row bg-primary p-2 text-white">
    <div class="col-12 col-lg-6">
        <?php
        $countSharepicsFile = 'log/countsharepics.txt';
        if(!file_exists($countSharepicsFile) OR time() - filemtime($countSharepicsFile) > 60 * 60){
            $countDownloads = 0;
            $lines = file('log/log.txt');
            foreach( $lines AS $line ){
                list( $time, $payload, $action ) = explode("\t", trim($line) );
                if($action == 'download') {
                    $countDownloads++;
                }
            }
            file_put_contents( $countSharepicsFile, (string) $countDownloads );
        }
        printf("%s erstellte Sharepics |", number_format( file_get_contents( $countSharepicsFile ), 0, ',', '.'));
        ?>
          <a href="bayern">
            Kommunalwahl Bayern</a>
    </div>

    <div class="col-12 col-lg-6 text-lg-right">
        <a href="https://chatbegruenung.de/channel/sharepicgenerator" target="_blank">Feedback im Chat-Channel</a> |
        <a href="https://github.com/codeispoetry/sharepicgenerator" target="_blank">Quellcode auf github.com</a> |
        Programmiert mit <i class="fas fa-heart text-yellow"></i> von 
        <a href="MAILTO:mail@tom-rose.de?subject=Sharepicgenerator">Tom Rose</a>.
    </div>
</footer>


<div class="overlays">
    <?php
        require_once('inc/overlays/pixabay.php');
        require_once('inc/overlays/icons.php');
        require_once('inc/overlays/waiting.php');
        require_once('inc/overlays/templates.php');

    ?>
</div>

<script>
    <?php echo 'var config ='; @readfile('config.json') || readfile('config-sample.json'); echo ';'?>
    <?php printf('config.landesverband = %d;', $landesverband); ?>
    <?php printf('config.user="%s";', $user); ?>
    <?php printf('config.accesstoken="%s";', $accessToken); ?>

   
</script>
<script src="./vendor/jquery-3.4.1.min.js"></script>
<script src="./vendor/bootstrap4-toggle.min.js"></script>

<script src="./vendor/svg.min.js"></script>
<script src="./vendor/svg.draggable.min.js"></script>
<script src="./assets/js/main.min.js"></script>

</body>
</html>
