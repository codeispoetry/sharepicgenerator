<?php
require_once('base.php');
require_once(getBasePath("lib/functions.php"));
useDeLocale();

session_start();

$landesverband = 0;
$user = "generic";
$tenant = "federal";

$hasAccess = isLocal() ?: isLocalUser();

if (!$hasAccess) {
    $user = handleSamlAuth();
}

$accesstoken = createAccessToken($user);
$_SESSION['accesstoken'] = $accesstoken;
$_SESSION['user'] = $user;
$_SESSION['landesverband'] = $landesverband;

$csrf = uniqid();
$_SESSION['csrf'] = $csrf;

logLogin();

require_once(getBasePath("lib/actionday.php"));

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="theme-color" content="#46962b">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sharepicgenerator</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap4-toggle.min.css">
    <link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#46962b">
    <meta name="msapplication-TileImage" content="/favicons/ms-icon-144x144.png">
    <script>
        <?php echo 'var config =';
        @readfile(getBasePath('/config.json')) || readfile(getBasePath('/config-sample.json')); echo ';'?>
        <?php printf('config.csrf="%s";', $csrf); ?>
        <?php printf('config.user="%s";', $user); ?>
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">

        <div class="col-12 col-lg-9">
            <div class="col-12 text-center pt-4 pb-3">
                <h1 class="text-uppercase h6"><a href="/index.php" class="text-body">Sharepicgenerator</a></h1>
            </div>
            <div class="col-12">
                <div id="canvas">
                    <div id="grid-horizontal-center" class="gridline horizontal d-none"></div>
                    <div id="grid-horizontal-upper" class="gridline horizontal d-none"></div>
                    <div id="grid-horizontal-lower" class="gridline horizontal d-none"></div>
                    <div id="grid-vertical-center" class="gridline vertical d-none"></div>
                    <div id="grid-vertical-left" class="gridline vertical d-none"></div>
                    <div id="grid-vertical-right" class="gridline vertical d-none"></div>
                    <div id="grid-round" class="gridline d-none"></div>
                </div>
            </div>
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

            <div class="col-12 text-center mb-5">
                <div>
                    <label>
                        <input type="checkbox" id="add-to-gallery" name="add-to-gallery"> In der Galerie veröffentlichen
                    </label>
                    <a href="/gallery" target="_blank"><i class="fa fa-external-link-alt"></i></a>
                </div>
                <div>
                    <button class="btn btn-secondary btn-lg download" id="download">
                        <i class="fas fa-download"></i> Herunterladen
                    </button>
                </div>
            </div>

            <?php
                 nextActionDay();
            ?>

            <?php
            if (isDaysBefore("8.3.", 14)) {
                ?>
            <div class="col-12 text-center mb-5">
                <span class="uselogo text-primary cursor-pointer" data-logo="frauenrechte">
                <img src="/assets/logos/frauenrechte.svg">
                Am 8. März ist Frauentag. Nutze das grüne Frauenrechte-Logo
                </span>
            </div>
            <?php } ?>

            <?php
            if (isDaysBefore("9.5.", 14)) {
                ?>
                <div class="col-12 text-center mb-5">
                <span class="uselogo text-primary cursor-pointer" data-logo="europa">
                    <img src="../assets/logos/europa.svg">
                    Am 9. Mai ist Europatag. Nutze das grüne Europa-Logo
                </span>
                </div>
            <?php } ?>

        </div>
        <div class="col-12 col-lg-3 mt-3 mb-5 cockpit">
            <?php require_once('cockpit.php'); ?>
        </div>
    </div>
</div>

<footer class="row bg-primary p-2 text-white">
    <div class="col-12 col-lg-6">
        <a href="/documentation" target="_blank"><i class="fas fa-question-circle"></i> Anleitung</a>
        <a href="#" class="overlay-opener" data-target="actiondays"><i class="far fa-hand-point-right ml-3"></i> Aktionstage</a>
        <a href="/markdown" target="_blank"><i class="fas fa-table ml-3"></i> Tabelle erstellen</a>
        <a href="/gallery" target="_blank"><i class="fas fa-store ml-3"></i> Muster-Sharepics</a>
    </div>

    <div class="col-12 col-lg-6 text-lg-right">
        <a href="https://chatbegruenung.de/channel/sharepicgenerator" target="_blank"><i class="fas fa-comment-dots"></i> Feedback</a>
        <a href="https://github.com/codeispoetry/sharepicgenerator" target="_blank" class="ml-3"><i class="fab fa-github"></i> Quellcode</a>
        <a href="/imprint.php" target="_blank" class="ml-3"><i class="fas fa-balance-scale-right"></i> Impressum</a>
        <span class="ml-3">
            <i class="fas fa-spa text-yellow"></i> Programmiert von
            <a href="MAILTO:mail@tom-rose.de?subject=Sharepicgenerator">Tom Rose</a>.</span>
    </div>
</footer>

<div class="overlays">
    <?php
        require_once(getBasePath('/inc/overlays/pixabay.php'));
        require_once(getBasePath('/inc/overlays/icons.php'));
        require_once(getBasePath('/inc/overlays/waiting.php'));
        require_once(getBasePath('/inc/overlays/actiondays.php'));
    ?>
</div>

<script src="/vendor/jquery-3.4.1.min.js"></script>
<script src="/vendor/bootstrap.min.js"></script>
<script src="/vendor/bootstrap4-toggle.min.js"></script>

<script src="/vendor/svg.min.js"></script>
<script src="/vendor/svg.draggable.min.js"></script>
<script src="/vendor/svg.filter.min.js"></script>
<script src="/assets/js/main.min.js"></script>
<script src="/assets/js/federal.min.js"></script>

</body>
</html>
