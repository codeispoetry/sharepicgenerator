<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));

// FIXME: the function showGallery should be part of lib/gallery_functions.php
// phpcs:ignoreFile


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

logLogin();

require_once(getBasePath("/lib/actionday.php"));

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="theme-color" content="#46962b">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sharepicgenerator</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap4-toggle.min.css">
    <link rel="apple-touch-icon" sizes="57x57" href="../favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicons/favicon-16x16.png">
    <link rel="manifest" href="../favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#46962b">
    <meta name="msapplication-TileImage" content="../favicons/ms-icon-144x144.png">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center pt-4 pb-3">
            <h1 class="text-uppercase h2">Muster-Sharepics </h1>
            <small>von anderen zur Inspiration</small>
        </div>
    </div>
    <div class="row pb-5 mb-3">
        <?php
            showImages('img/shpic*.jpg');
        ?>
    </div>
</div>



<footer class="row bg-primary p-2 text-white">
    <div class="col-12 col-lg-6">
        <a href="/documentation" target="_blank"><i class="fas fa-question-circle"></i> Anleitung</a>
        <a href="#" class="overlay-opener" data-target="actiondays"><i class="far fa-hand-point-right ml-3"></i> Aktionstage</a>
        <a href="/markdown" target="_blank"><i class="fas fa-table ml-3"></i> Tabelle erstellen</a>
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



<script src="../vendor/jquery-3.4.1.min.js"></script>
<script src="../vendor/bootstrap.min.js"></script>
<script src="../vendor/bootstrap4-toggle.min.js"></script>


</body>
</html>
<?php

function showImages($dir)
{
    $files = array_reverse(glob($dir));
    foreach ($files as $file) {
        $info = array(
            'Datum' => strftime('%e. %B %Y', filemtime($file)),
            'ID' => basename($file, '.jpg'),
        );

        $infofile = 'img/' . basename($file, 'jpg').'json';
        if (file_exists($infofile)) {
            $info = array_merge(json_decode(file_get_contents($infofile), true), $info);
        } ?>
        <div class="col-4 col-md-3 col-lg-3">
            <figure>
                <img src="<?php echo $file?>" class="img-fluid"/>
                <figcaption>
                    <table class="small">
                        <?php foreach ($info as $key => $value) { ?>
                        <tr>
                            <td class="pr-3 "><?php echo $key; ?>:</td>
                            <td><?php echo $value; ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </figcaption>
            </figure>
        </div>
        <?php
    }
}
