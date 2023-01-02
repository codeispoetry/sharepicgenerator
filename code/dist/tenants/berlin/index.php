<?php
require_once('base.php');
require_once(getBasePath("lib/functions.php"));
require_once(getBasePath("lib/login_functions.php"));
require_once(getBasePath("lib/save_functions.php"));
useDeLocale();

session_start();
readConfig();

$landesverband = 0;
$user = "generic";
$tenant = "berlin";

$user =  do_saml_login();

if ( isset($hasAccess) AND !$hasAccess) {
    $user = handleSamlAuth($doLogout);
}

$accesstoken = createAccessToken($user);
$_SESSION['accesstoken'] = $accesstoken;
$_SESSION['user'] = $user;
$_SESSION['landesverband'] = $landesverband;
$_SESSION['tenant'] = $tenant;


$csrf = uniqid();
$_SESSION['csrf'] = $csrf;

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="theme-color" content="#46962b">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sharepicgenerator</title>
    <link rel="stylesheet" type="text/css" href="<?php latestVersion('/assets/css/styles.css');?>">
    <link rel="stylesheet" type="text/css" href="/node_modules/bootstrap4-toggle/css/bootstrap4-toggle.min.css">
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/assets/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicons/favicon-16x16.png">
    <link rel="preload" href="/assets/fonts/BereitBold-Oblique.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="manifest" href="/assets/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#46962b">
    <meta name="msapplication-TileImage" content="/assets/favicons/ms-icon-144x144.png">
    <script>
        var config = {};
        <?php echo pixabayConfig(); ?>
        <?php printf('config.csrf="%s";', $csrf); ?>
        <?php printf('config.tenant="%s";', "berlin"); ?>
        config.imageDBSearchIn="images";
        config.backgroundSource="standard";
        config.faces=-1;
        config.uploadTime=-1;

        config.format='png';
        config.user = {};
        config.user.prefs = {};
    </script>
</head>
<body class="h-100">
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-pistazie">
    <button class="navbar-toggler" type="button" data-toggle="collapse" 
        data-target="#uppernavbar" aria-controls="uppernavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between ms-2 me-2" id="uppernavbar">
        <?php require_once('../menu.php'); ?>
    </div>
    </nav>
</header>
<div class="container-fluid">
    <div class="row h-100 flex-row-reverse">
        <div class="col-12 col-lg-9 canvas-wrapper p-0">
            <div class="col-12 p-0 pt-3">
                <div id="canvas-area">
                    <div id="canvas">
                        <div id="grid-horizontal-center" class="gridline horizontal"></div>
                        <div id="grid-horizontal-upper" class="gridline horizontal"></div>
                        <div id="grid-horizontal-lower" class="gridline horizontal"></div>
                        <div id="grid-vertical-center" class="gridline vertical"></div>
                        <div id="grid-vertical-left" class="gridline vertical"></div>
                        <div id="grid-vertical-right" class="gridline vertical"></div>
                        <div id="grid-round" class="gridline"></div>
                    </div>
                    <div class="text-center mt-5">
                        <div>
                            <button class="btn btn-secondary btn-lg download bereitbold" id="download">
                                <i class="fas fa-download"></i> Herunterladen
                            </button>
                        </div>
                        <div id="qrcode" class="qrcode mt-5" style="display:none">
                            Du kannst Dein Sharepic auch auf Dein Handy herunterladen.<br>
                            Scanne dazu diesen Code:<br>
                            <div id="qrcode-img">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <?php
            require_once(getBasePath('/lib/overlays/waiting.php'));
           
            require_once(getBasePath('/lib/overlays/imagedb.php'));
            require_once(getBasePath('/lib/overlays/preferences.php'));
            require_once(getBasePath('/lib/overlays/faq.php'));


            ?>

            <div class="col-12 mt-3 mb-3">
                <div id="message" class="bg-danger text-white p-4" style="display:none"></div>
                <div id="warning" class="text-danger text-center p-4" style="display:none">Gesicht</div>
            </div>

            </div>
        <div class="col-12 col-lg-3 p-0">
            <div class="cockpit h-100">
                <?php require_once('cockpit.php'); ?>
            </div> 
        </div>
    </div>
</div>


<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script src="/node_modules/popper.js/dist/umd/popper.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/node_modules/bootstrap4-toggle/js/bootstrap4-toggle.min.js"></script>
<script src="/node_modules/@svgdotjs/svg.js/dist/svg.min.js"></script>
<script src="/node_modules/@svgdotjs/svg.draggable.js/dist/svg.draggable.min.js"></script>
<script src="/node_modules/@svgdotjs/svg.filter.js/dist/svg.filter.min.js"></script>

<script src="<?php latestVersion('/assets/js/main.min.js');?>"></script>
<script src="<?php latestVersion('/assets/js/berlin.min.js');?>"></script>



<script>
<?php
if (isset($_GET['useSavework'])) {
    $saveData = reuseSavework($_GET['useSavework']);
    if (isset($saveData)) {
        printf('loadSavework(%s);', $saveData);
    }
}

if (isset($_GET['usePicture'])) {
    printf('uploadFileByUrl(`../tenants/berlin/%s`, () => {})', $_GET['usePicture']);
}
?>
    config.user.prefs = jQuery.parseJSON('<?php echo getUserPrefs(); ?>');
    config.username = '<?php echo getUser(); ?>';
</script>

</body>
</html>
