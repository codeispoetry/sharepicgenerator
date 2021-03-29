<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sharepicgenerator</title>
    <meta name="theme-color" content="#46962b">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="assets/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicons/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#46962b">
    <meta name="msapplication-TileImage" content="favicons/ms-icon-144x144.png">

    <style>
    body {
      background-image: linear-gradient(180deg, #eee, #fff 100px, #fff);
    }

    .container {
      max-width: 960px;
    }

    .pricing-header {
      max-width: 700px;
    }

    .link-secondary{
      color: #6c757d;
    }
    .link-secondary:hover{
      color: #46962b;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
</head>
<?php
  require_once('base.php');
  require_once('lib/functions.php');
  require_once('lib/log_functions.php');


?>
<body>
<div class="container py-3">
  <header class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
      <img class="mr-2" src="assets/img/logo.svg" alt="" width="40" height="40">
      <span class="fs-4">Sharepicgenerator.de</span>
    </a>
  </header>

  <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
    <h1 class="display-4 fw-normal">Sharepicgenerator</h1>
    <p class="fs-5 text-muted">Erstelle Bilder mit Text für Social Media und Co. </p>
  </div>

  <main>
    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
      <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Ohne Anmeldung</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled mt-3 mb-4">
              <li>Logo hochladen</li>
              <li>Schrift hochladen</li>
              <li>Hintergrundbild aussuchen</li>
              <li>Text eingeben</li>
              <li>herunterladen</li>
            </ul>
            <a href="/tenants/basic/?guest=1" class="w-100 btn btn-lg btn-dark">Sharepic erstellen</a>
            &nbsp;
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Mit Anmeldung</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled mt-3 mb-4">
              <li>Logo speichern</li>
              <li>Schrift speichern</li>
              <li>Hintergrundbild aussuchen</li>
              <li>Text eingeben</li>
              <li>herunterladen</li>
            </ul>
            <a href="/tenants/basic" class="w-100 btn btn-lg btn-info">anmelden</a>
            <a href="/wordpress/wp-login.php?action=register" class="">registrieren</a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm border-primary">
          <div class="card-header py-3 text-white bg-primary border-primary">
            <h4 class="my-0 fw-normal">
                B'90/Grüne
              <img src="/assets/logos/sonnenblume.svg" style="height: 1em;margin-left: 10px" >
            </h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled mt-3 mb-4">
              <li>original grünes Design</li>
              <li>Mustervorlagen</li>
              <li>Videofunktion</li>
              <li>Arbeitsdateien</li>
              <li>
                <a href="/tenants/bw">Baden-Württemberg</a> |
                <a href="/tenants/frankfurt">Frankfurt</a>
              </li>
            </ul>
            <a href="tenants/federal" type="button" class="w-100 btn btn-lg btn-primary">einloggen</a>
            <a href="https://www.gruene.de/mitglied-werden" target="_blank" class="">Mitglied werden</a>

          </div>
        </div>
      </div>
    </div>

  </main>

  <footer class="pt-4 my-md-5 pt-md-5 border-top position-relative">
    <div class="row">
      <div class="col-12 col-md">
        <img class="mb-2" src="assets/img/logo.svg" alt="" width="24" height="19">
        <small class="d-block mb-3 text-muted">by Tom Rose</small>
      </div>
      <div class="col-6 col-md">
        <h5>Über</h5>
        <ul class="list-unstyled text-small">
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="/imprint.php">Impressum</a></li>
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="https://github.com/codeispoetry/sharepicgenerator">Quellcode</a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Hilfen</h5>
        <ul class="list-unstyled text-small">
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="/documentation">Handbuch</a></li>
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="https://github.com/codeispoetry/sharepicgenerator/issues">Fehler melden</a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Features</h5>
        <ul class="list-unstyled text-small">
          <li class="mb-1">Anpassbare Ausgabegröße</li>
          <li class="mb-1">Bildausschnitt frei wählbar</li>
          <li class="mb-1">für Bilder und Videos</li>
          <li class="mb-1">eigenes Logo</li>
          <li class="mb-1">eigene Schriftart</li>
        </ul>
      </div>
    </div>
  </footer>
</div>


<?php
  // delete tmp-files
  deleteFilesInPathOlderThanHours(getBasePath('tmp/*'), 'log*', 2 * 24);
  // but keep log-files longer
  deleteFilesInPathOlderThanHours(getBasePath('tmp/log*'), null,  7 * 24);
  // delete videos and zips more often
  deleteFilesInPathOlderThanHours(getBasePath('tmp/*.mp4'), null,  6);
  deleteFilesInPathOlderThanHours(getBasePath('tmp/*.zip'), null,  6);
  deleteFilesInPathOlderThanHours(getBasePath('tmp/qrcode_*'), null,  2);
  deleteFilesInPathOlderThanHours(getBasePath('tmp/work*'), null,  6);
  deleteFilesInPathOlderThanHours(getBasePath('tmp/fonts/*'), null,  6);

?>
</body>
</html>
