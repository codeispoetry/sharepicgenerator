<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <title>Sharepicgenerator</title>
    <meta name="theme-color" content="#46962b">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <style>
header {
  position: relative;
  background-color: black;
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
}

header .container {
  position: relative;
  z-index: 2;
}

header .overlay {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background-color: black;
  opacity: 0.5;
  z-index: 1;
}

.text-shadow{
  text-shadow: black 1px 1px 12px;
}

@media (pointer: coarse) and (hover: none) {
  header {
    background: #46962b;
    height: auto;
    padding: 5em 0;
  }
  header video {
    display: none;
  }
}
    </style>
</head>
<body>

<header>
  <div class="overlay"></div>
  <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
    <source src="assets/background.mp4" type="video/mp4">
  </video>
  <div class="container h-100">
    <div class="d-flex h-100 text-center align-items-center">
      <div class="w-100 text-white">
        <h1 class="display-3 text-shadow">Sharepic&shy;generator</h1>
        <p class="lead mb-0 text-shadow">Erstelle Deine eigenen Sharepics für Social Media und Co.</p>
        <div class="mt-3">
          <a href="create.php" class="mt-5 btn btn-secondary btn-lg">eigenes Sharepic erstellen</a>
          <br/>
          <a href="bayern" class="mt-2 btn btn-info btn-sm">Kommunalwahl Bayern</a>

        </div>
      </div>
    </div>
  </div>
</header>

<section class="my-5">
  <div class="container">
  <div class="row">
      <div class="col-md-8 mx-auto">
        <h2>Beispiele</h2>
        <div class="row">
          <div class="col-6"><img src="assets/example1.jpg" class="img-fluid"></div>
          <div class="col-6"><img src="assets/example2.jpg" class="img-fluid"></div>
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-md-8 mx-auto">
        <h2>Featureliste</h2>
        <ul>
          <li>Anpassbare Ausgabegröße</li>
          <li>Bildausschnitt frei wählbar</li>
          <li>Templates für alle gängigen Social-Media-Plattformen</li>
          <li>eigenes Bild hochladbar</li>
          <li>Bilder von <a href="https:/.pixabay.com/de" target="_blank">Pixabay</a></li>
          <li>Icons von <a href="https://thenounproject.com/" target="_blank">TheNounProject</a></li>
          <li>Eigenes Logo wird dauerhaft gespeichert</li>
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
    </div>

    <div class="col-12 col-lg-6 text-lg-right">
        Programmiert mit <i class="fas fa-heart text-yellow"></i> von Tom Rose.
    </div>
</footer>


</body>
</html>