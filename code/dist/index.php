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
     @font-face {font-family: "BereitBold";src: url("../assets/typefaces/BereitBold.woff2") format("woff2");}
     .bereitbold{font-family: 'BereitBold';font-weight: 500;}
     @font-face {font-family: "PT Sans";src: url("../assets/typefaces/PT Sans.woff2") format("woff2");}
     .ptsans{font-family: 'PT Sans';font-weight: 500;}
    
    .container {
      max-width: 960px;
    }

    .bgimage{
        background: url(assets/startimage.jpg);
        background-size: cover;
        min-height: 600px;
        position: relative;
     }

    #loginscreen{
        max-width: 400px;
        border-radius: 10px;
        padding: 2em;
        background: rgba(255,255,255, 0.9);
    }

    #loginscreen *{
        text-decoration: none;
        color: #333333;
    }

    #loginscreen a.tenant{
      text-decoration: underline;
      color: #145f32;
    }
     #loginscreen a.tenant:hover{
      color: #4cb4e7;
    }

    #claim{
        color: white;
        font-family: BereitBold;
    }

    #claim h1{
        font-size: 7em;
    }

    #sunflower {
        width: 120px;
        height: 120px;
        margin-left: 2em;
    }

    .subhead{
        font-size: 5em;
    }

      @media (max-width: 768px) {
          .bgimage {
              min-height: 230px;
          }
      }
    </style>
</head>
<?php
  require_once('base.php');
  require_once('lib/functions.php');
  require_once('lib/log_functions.php');

  readConfig();


?>
<body style="background:white">
<div class="container-fluid p-0 position-relative h-100">
  <header class="container d-flex justify-content-between">
    <div class="my-auto">
        <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
            <img class="me-2" src="assets/btw21/logo.svg" alt="" width="40" height="40">
            <span class="fs-4">Sharepic&shy;generator.de</span>
        </a>
    </div>
      <div class="d-flex align-items-center">
        <a href="https://www.gruene.de/mitglied-werden" target="_blank" class="me-2 text-decoration-none text-black-50 small">Mitglied werden</a>
        <div class="btn-pistazie">
            <a href="btw21" type="button" class="btn btn-md btn-pistazie p-4">
                 anmelden <i class="fas fa-sign-in-alt me-1"></i></a>
        </div>
    </div>

  </header>

  <div class="p-3 bgimage d-md-flex align-items-end justify-content-between">
      <div id="claim" class="d-none d-md-flex align-baseline">
          <div>
              <h1 class="">Sharepic&shy;generator</h1>
              <p class="subhead">Werde kreativ!</p>
          </div>
          <img src="assets/btw21/logo.svg" id="sunflower">
      </div>
      <div id="loginscreen">
          <a href="/de" class="">
              <h2 class="display-6 fw-normal bereitbold">Sharepic&shy;generator</h2>
              <p class="fs-5">Erstelle Bilder mit Text für Social Media und Co. im grünen Design </p>
              <div class="w-100 btn btn-lg btn-moos text-white">
                  <?php
                    echo (file_exists('scripts/status/saml_is_up')) ? 'anmelden' : 'Notdienst für Sharepics nutzen    ';
                  ?>
              </div>
              <div class="small font-italic mt-2">
                <em>
                  Bei Problemen mit der Anmeldung wende Dich bitte an 
                  <a href="MAILTO:netz@gruene.de" class="text-primary">netz@gruene.de</a>.
               </em>
              </div>
          </a>
      </div>
  </div>

  <footer class="bg-primary p-5 h-100">
      <div class="container">
         <div class="row">
      <div class="col-6 col-md">
        <h5>Über</h5>
        <ul class="list-unstyled text-small">
          <li class="mb-1"><a class="" href="/imprint.php">Impressum</a></li>

          <li class="mb-1"><a class="" href="MAILTO:tom.rose@sharepicgenerator.de">Kontakt</a></li>
          <li class="mb-1"><a class="" href="/imprint.php">Datenschutz</a></li>

        </ul>
      </div>
      <div class="col-6 col-md text-md-center">
        <h5>Sondermodelle</h5>
        <ul class="list-unstyled text-small">
            <?php
            foreach (getActiveTenants() as $key => $value) {
                printf(
                    '<li class="mb-1"><a href="/%1$s" class="">%2$s</a></li>',
                    $key,
                    $value
                );
            }
            ?>

        <li>
            <form method="post" class="test-access" action="de/">
                <input type="password" id="test-access-password" class="" name="pass" placeholder="Gastzugang">
            </form>
        </li>
        </ul>
      </div>
      <div class="col-6 col-md text-md-end">
        <h5>Hilfen</h5>
        <ul class="list-unstyled text-small">
          <li class="mb-1"><a class="" href="https://github.com/codeispoetry/sharepicgenerator">Quellcode</a></li>
          <li class="mb-1"><a class="" href="https://github.com/codeispoetry/sharepicgenerator/issues">Fehler melden</a></li>

        </ul>
      </div>
    </div>
      </div>
  </footer>
</div>

</body>
</html>
