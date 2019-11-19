<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sharepicgenerator Bayern</title>
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>
<body>

<div id="content">
    <div id="canvas"></div>

    <div id="cockpit">
        <div id="upload">
            <span class="message"></span>
            <input type='file' id="uploadfile" accept='image/*'>
        </div>
        <div>
            <button id="download">Download</button>
        </div>
        <div>
            <h6>Slogan</h6>
            <textarea id="text">Hier der Text</textarea><br>
            <small>Zeilen, die mit einem<br>
                Ausrufezeichen ! beginnen,<br>
                werden hervorgehoben</small>
        </div>
        <div>
            <h6>Textgröße</h6>
            <div class="slider">
                <small>klein</small>
                <input type="range" id="textfieldresize" min="1" max="100">
                <small>groß</small>
            </div>
        </div>
        <div>
            <h6>Pingröße</h6>
            <div class="slider">
                <small>klein</small>
                <input type="range" id="pinresize" min="1" max="100">
                <small>groß</small>
            </div>
        </div>
        <div>
            <h6>Logogröße</h6>
            <div class="slider">
                <small>klein</small>
                <input type="range" id="logoresize" min="1" max="100">
                <small>groß</small>
            </div>
        </div>
        <div>
            <h6>Webadresse</h6>
            <input type="text" id="subline" value="gruene-bayern.de">
        </div>
        <div>
            <h6>Größe</h6>
            <input type="number" id="width" class="size" value=""> x
            <input type="number" id="height" class="size" value=""> Pixel
        </div>
        <div>
            <h6>Hintergrundbild</h6>
            <a href="#" id="resetBackground">Hintergrund zurücksetzen</a>
            <div class="slider">
                <small>klein</small>
                <input type="range" id="backgroundresize" min="1" max="100">
                <small>groß</small>
            </div>
        </div>
        <div>
            <h6>Pixabay</h6>
            <button id="pixabayopener">Bilder suchen</button>
        </div>
    </div>

    <div id="pixabay" class="overlay">
        <a href="#" class="close">schließen</a>
        <form>
            <input type="text" class="q" value="berge">
            <input type="submit" i value="suchen">
        </form>
        <div class="results"></div>
    </div>

    <div id="waiting" class="overlay">
        Augenblick bitte
    </div>

    <script>
        // some arbitrary value > 0
        var info = {
            width: 10,
            height: 10,
            originalWidth: 10,
            originalHeight: 10,
            size: 10,
            x: 15,
            y: 50,
        };
    </script>
    <script src="./vendor/jquery-3.4.1.min.js"></script>
    <script src="./vendor/svg.min.js"></script>
    <script src="./vendor/svg.draggable.min.js"></script>
    <script src="./js/main.min.js"></script>
</body>
</html>