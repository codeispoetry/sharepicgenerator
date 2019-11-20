<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sharepicgenerator Bayern</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Sharepicgenerator Bayern</h1>
    </header>
    <div id="workspace">
        <div id="workbench">
            <div id="canvas"></div>
            <div id="message"></div>
        </div>
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
                <textarea id="text">grün tut gut</textarea><br>
                <small>Zeilen, die mit einem<br>
                    Ausrufezeichen ! beginnen,<br>
                    werden hervorgehoben</small>
            </div>
            <div>
                <h6>Textgröße</h6>
                <div class="slider">
                    <small>klein</small>
                    <input type="range" id="textsize" min="1" max="100">
                    <small>groß</small>
                </div>
            </div>
            <div>
                <h6>Pin</h6>
                <div class="slider">
                    <small>klein</small>
                    <input type="range" id="pinsize" min="1" max="100">
                    <small>groß</small>
                </div>
            </div>
            <div>
                <h6>Zeile unten</h6>
                <input type="text" id="subline" value="gruene-bayern.de">
            </div>
            <div>
                <h6>Größe</h6>
                <a href="#" id="sizereset">zurücksetzen</a><br>
                <input type="number" id="width" class="size" step="10"> x
                <input type="number" id="height" class="size" step="10"> Pixel
            </div>
            <div>
                <h6>Hintergrundbild</h6>
                <a href="#" id="backgroundreset">zurücksetzen</a>
                <div class="slider">
                    <small>klein</small>
                    <input type="range" id="backgroundsize" min="1" max="1500" value="1200">
                    <small>groß</small>
                </div>
            </div>
            <div>
                <h6>Pixabay</h6>
                <button id="pixabayopener">Bilder suchen</button>
            </div>
            <div>
                <input type="hidden" id="pinX">
                <input type="hidden" id="pinY">
                <input type="hidden" id="backgroundX">
                <input type="hidden" id="backgroundY">
                <input type="hidden" id="textX">
                <input type="hidden" id="textY">
            </div>
        </div>
    </div>
        <div class="overlays">
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
        </div>


    <script src="./vendor/jquery-3.4.1.min.js"></script>
    <script src="./vendor/svg.min.js"></script>
    <script src="./vendor/svg.draggable.min.js"></script>
    <script src="./assets/js/main.min.js"></script>
</body>
</html>