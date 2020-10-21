<?php
require_once('base.php');
require_once(getBasePath("lib/functions.php"));
require_once(getBasePath("lib/save_functions.php"));
require_once(getBasePath("lib/gallery_functions.php"));

useDeLocale();

session_start();
readConfig();

$landesverband = 0;
$user = "generic";
$tenant = "frankfurt";

$hasAccess = isLocal() ?: isLocalUser();

$doLogout = false;
if (isset($_GET['logout']) && ($_GET['logout'] == 'true')) {
    $doLogout = true;
}

if (!$hasAccess) {
    $user = handleSamlAuth($doLogout);
}

$accesstoken = createAccessToken($user);
$_SESSION['accesstoken'] = $accesstoken;
$_SESSION['user'] = $user;
$_SESSION['landesverband'] = $landesverband;
$_SESSION['tenant'] = $tenant;


$csrf = uniqid();
$_SESSION['csrf'] = $csrf;

logLogin();

require_once(getBasePath("lib/actionday.php"));
nextActionDay();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="theme-color" content="#46962b">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sharepicgenerator/Frankfurt</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap4-toggle.min.css">
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
    <link rel="manifest" href="/assets/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#46962b">
    <meta name="msapplication-TileImage" content="/assets/favicons/ms-icon-144x144.png">
    <script>
        <?php echo 'var config = {};'; ?>
        <?php echo pixabayConfig(); ?>
        <?php printf('config.csrf="%s";', $csrf); ?>
        <?php printf('config.user="%s";', $user); ?>
        <?php printf('config.tenant="%s";', "frankfurt"); ?>
        <?php printf('config.pixabaySearchIn="images";'); ?>

    </script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <button class="navbar-toggler" type="button" data-toggle="collapse" 
        data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand arvo" href="/tenants/frankfurt">Sharepicgenerator.de/frankfurt</a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Hilfe
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a href="/documentation" target="_blank" class="dropdown-item"><i class="fas fa-question-circle"></i> Anleitung</a>
                    <a href="#" class="overlay-opener dropdown-item" data-target="gallery"><i class="fas fa-store"></i> Vorlagen</a>
                    <a href="#" class="overlay-opener dropdown-item" data-target="actiondays" id="actiondaysopener">
                        <i class="far fa-hand-point-right"></i> Aktionstage
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Über
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a href="https://chatbegruenung.de/channel/sharepicgenerator" class="dropdown-item" target="_blank">
                    <i class="fas fa-comment-dots"></i> Feedback</a>
                <a href="https://github.com/codeispoetry/sharepicgenerator" class="dropdown-item" target="_blank">
                    <i class="fab fa-github"></i> Quellcode</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="/imprint.php" class="nav-link"> Impressum</a>
            </li>
        </ul>
        <span class="navbar-text">
            Eingeloggt als <em><?php echo getUser(); ?></em>
            <a href="?logout=true" class="ml-2"><i class="fas fa-sign-out-alt" title="Ausloggen"></i></a>
        </span>
    </div>
    </nav>
</header>
<div class="container-fluid h-100">
    <div class="row h-100 flex-row-reverse">

        <div class="col-12 col-lg-9 pt-4 canvas-wrapper">
            <div class="col-12">
                <div id="canvas-area">
                    <div id="canvas">
                        <div id="grid-horizontal-center" class="gridline horizontal d-none"></div>
                        <div id="grid-horizontal-upper" class="gridline horizontal d-none"></div>
                        <div id="grid-horizontal-lower" class="gridline horizontal d-none"></div>
                        <div id="grid-vertical-center" class="gridline vertical d-none"></div>
                        <div id="grid-vertical-left" class="gridline vertical d-none"></div>
                        <div id="grid-vertical-right" class="gridline vertical d-none"></div>
                        <div id="grid-round" class="gridline d-none"></div>
                    </div>
                    <div class="text-center mt-5">
                        <div>
                            <button class="btn btn-secondary btn-lg download" id="download">
                                <i class="fas fa-download"></i> Herunterladen
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                require_once(getBasePath('/lib/overlays/pixabay.php'));
                require_once(getBasePath('/lib/overlays/waiting.php'));
                require_once(getBasePath('/lib/overlays/actiondays.php'));
                require_once(getBasePath('/lib/overlays/icons.php'));
                require_once(getBasePath('/lib/overlays/gallery.php'));
                require_once(getBasePath('/lib/overlays/pictures.php'));
            ?>

            <div class="col-12 mt-3 mb-3">
                <div id="message" class="bg-danger text-white p-4" style="display:none"></div>
                <div id="warning" class="text-danger text-center p-4" style="display:none">Gesicht</div>
                <div id="actiondayshint" class="text-center p-4" style="display:none">
                    Du scheinst für einen Aktionstag ein Sharepic zu erstellen.<br>
                    Falls dieser Aktionstag noch nicht in der
                    <a href="#" class="overlay-opener" data-target="actiondays"> Liste der Aktionstage</a>
                    ( <?php echo getNextActionDays(3); ?>, <a href="#" class="overlay-opener" data-target="actiondays">...</a>)
                    enthalten ist,<br>
                    <a href="https://chatbegruenung.de/channel/sharepicgenerator" target="_blank"> schlage ihn vor</a>,
                    damit auch andere daran denken. #Danke.
                </div>
            </div>

            </div>
        <div class="col-12 col-lg-3 p-0">
            <div class="cockpit h-100">
                <?php require_once('cockpit.php'); ?>
            </div> 
        </div>
    </div>

    <?php
        require_once(getBasePath('/lib/toasts/toasts.php'));
    ?>
</div>
<div class="overlays">
    <?php
        require_once(getBasePath('/lib/overlays/logos.php'));
    ?>
</div>


<script src="/vendor/jquery-3.4.1.min.js"></script>
<script src="/vendor/popper.min.js"></script>
<script src="/vendor/bootstrap.min.js"></script>
<script src="/vendor/bootstrap4-toggle.min.js"></script>



<script src="/vendor/svg.min.js"></script>
<script src="/vendor/svg.draggable.min.js"></script>
<script src="/vendor/svg.filter.min.js"></script>
<script src="/assets/js/main.min.js?v=<?php echo @filemtime('../../assets/js/main.min.js'); ?>"></script>
<script src="/assets/js/frankfurt.min.js?v=<?php echo @filemtime('../../assets/js/frankfurt.min.js'); ?>"></script>



<script>
<?php
if (isset($_GET['useSavework'])) {
    $saveData = reuseSavework($_GET['useSavework']);
    if (isset($saveData)) {
        printf('loadSavework(%s);', $saveData);
    }
}
if (isset($_GET['usePicture'])) {
    printf('uploadFileByUrl(`../tenants/frankfurt/%s`, () => {})', $_GET['usePicture']);
}

?>
</script>

</body>
</html>
