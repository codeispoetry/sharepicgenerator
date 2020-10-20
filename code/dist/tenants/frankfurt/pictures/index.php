<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/gallery_functions.php'));
useDeLocale();

session_start();
readConfig();

if (!isAllowed(false)) {
    header("Location: ". configValue("Main", "logoutTarget"));
    die();
}

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
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center pt-4 pb-3">
            <h1 class="text-uppercase h2">Mediengalerie</h1>
        </div>
    </div>
    <div id="picture-list">
      <div class="pb-3">
        <input class="search" placeholder="Suche" />
        <button class="sort" data-sort="llname">Nach Name sortieren</button>
        <button class="sort" data-sort="llalbum">Nach Album sortieren</button>
      </div>
      <div class="row pb-5 mb-3 list">
        <?php
          showPictures('img/');
        ?>
      </div>
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
            <i class="fas fa-spa text-highlight"></i> Programmiert von
            <a href="MAILTO:mail@tom-rose.de?subject=Sharepicgenerator">Tom Rose</a>.</span>
    </div>
</footer>

<script src="/vendor/jquery-3.4.1.min.js"></script>
<script src="/vendor/bootstrap.min.js"></script>
<script src="/vendor/bootstrap4-toggle.min.js"></script>
<script src="/vendor/list.min.js"></script>

<script>
var options = {
  valueNames: [ 'llalbum', 'llname', 'llphotographer', 'lltags' ]
};

let hackerList = new List('picture-list', options);

</script>

</body>
</html>
