<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sharepicgenerator</title>
    <meta name="theme-color" content="#46962b">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
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
    <link rel="manifest" href="/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#46962b">
    <meta name="msapplication-TileImage" content="favicons/ms-icon-144x144.png">
    <style>

header {
  position: relative;
  background-color: white;
  height: 75vh;
  min-height: 25rem;
  width: 100%;
  overflow: hidden;
}

header video {
  position: absolute;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  z-index: 0;
  -ms-transform: translateX(-50%) translateY(-50%);
  -moz-transform: translateX(-50%) translateY(-50%);
  -webkit-transform: translateX(-50%) translateY(-50%);
  transform: translateX(-50%) translateY(-50%);
  filter: grayscale(50%);
}

header .container {
  position: relative;
  z-index: 2;
}

.text-shadow{
  text-shadow: black 1px 1px 12px;
}

@media (pointer: coarse) and (hover: none) {
  header {
    background: #46962b;
    height: auto;
    padding: 5em 0;
    width: 100%;
  }
  header video {
    display: none;
  }
}
    </style>
</head>
<body>
<div class="container-fluid">

<div class="row">
<header>
  <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
    <source src="assets/background.mp4" type="video/mp4">
  </video>
  <div class="container h-100">
    <div class="d-flex h-100 text-center align-items-center">
      <div class="w-100 text-white">
        <h1 class="display-4 text-shadow">Grüner<br/>Sharepic&shy;generator</h1>
        <p class="lead mb-0 text-shadow">Erstelle Deine eigenen Sharepics für Social Media und Co.</p>
        <div class="mt-3 d-flex flex-column align-items-center">
          <a href="federal/" class="mt-5 btn btn-secondary btn-lg">
            <i class="fas fa-pen mr-2 small"></i>eigenes Sharepic erstellen
          </a>
          <a href="bayern" class="mt-2 btn btn-info btn-sm"><i class="fas fa-pen-fancy"></i> Kommunalwahl Bayern</a>
          <a href="vintage/" class="mt-5 btn btn-dark btn-sm"><i class="fab fa-pied-piper-alt"></i> Vintage-Version zum 30./40. Geburtstag</a>
         
         
            <span class="mt-5 cursor-pointer testaccess">
                <i class="fas fa-sign-in-alt"></i> Gastzugang
            </span>
            <div class="mt-1 testaccess" style="display:none">
                <form method="post" action="bayern/" class="form-inline">
                    <div class="mt-2">
                        <input type="text" class="form-control" name="pass" placeholder="Passwort eingeben">
                        <input type="submit" class="btn btn-sm btn-info" value="okay">
                    </div>
                </form>
                <a href="MAILTO:mail@tom-rose.de?subject=Sharepicgenerator" class="d-none text-white">
                  <i class="fas fa-envelope"></i> Testzugang beantragen
                </a>
            </divmt-3>
        </div>
      </div>
    </div>
  </div>
</header>
</div>

<section class="row my-5">
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-8 offset-md-2 ">
        <h2>Beispiele</h2>
        <div class="row">
          <div class="col-6"><img src="assets/example1.jpg" class="img-fluid"></div>
          <div class="col-6"><img src="assets/example2.jpg" class="img-fluid"></div>
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-md-8 offset-md-2 ">
        <h2>Featureliste</h2>
        <ul>
          <li>Anpassbare Ausgabegröße</li>
          <li>Bildausschnitt frei wählbar</li>
          <li>für Bilder und Videos</li>
          <li>Templates für alle gängigen Social-Media-Plattformen</li>
          <li>eigenes Bild hochladbar</li>
          <li>Bilder von <a href="https://pixabay.com/de" target="_blank">Pixabay</a></li>
          <li>Icons von <a href="https://thenounproject.com/" target="_blank">TheNounProject</a></li>
          <li>Eigenes Logo wird dauerhaft gespeichert</li>
          <li>Bedienbar über einen Telegram-Bot</li>
          <li>Dark Mode für Wirkung auf dunklen Untergründen</li>
          <li>mit API, z.B. für Massenabfertigung</li>
          <li><a href="https://github.com/codeispoetry/sharepicgenerator" target="_blank">Open Source</a></li>
          <li><em>und vieles mehr</em></li>
        </ul>
      </div>
    </div>
  </div>
</section>


<footer class="row bg-primary p-2 text-white">
    <div class="col-12 col-lg-6">
    <a href="https://github.com/codeispoetry/sharepicgenerator" target="_blank">Quellcode auf github.com</a> 
    | <a href="imprint.php">Impressum</a>
    </div>

    <div class="col-12 col-lg-6 text-lg-right">
        Programmiert mit <i class="fas fa-heart text-yellow"></i> von 
        <a href="MAILTO:mail@tom-rose.de?subject=Sharepicgenerator">Tom Rose</a>.
    </div>
</footer>

</div>
<script src="./vendor/jquery-3.4.1.min.js"></script>
<script>
    $('span.testaccess').click(function(){
      if( $('div.testaccess').is(':visible') ){
        $('div.testaccess').slideUp();
      }else{
        $('div.testaccess').slideDown();
      }
    });

</script>

</body>
</html>