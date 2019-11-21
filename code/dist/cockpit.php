<div class="list-group">
    <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Textgröße</h5>
            <small></small>
        </div>
        <div class="mb-1">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="custom-range" id="textsize" min="1" max="100">
                <small>groß</small>
            </div>
        </div>
        <small></small>
    </div>

 <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Pin</h5>
            <small></small>
        </div>
        <div class="mb-1">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="custom-range" id="pinsize" min="1" max="100">
                <small>groß</small>
            </div>
        </div>
        <small></small>
    </div>


</div>





<div id="upload">
    <span class="message"></span>
    <input type='file' id="uploadfile" accept='image/*'>
</div>
<div>
    <button id="download">Download</button>
</div>
<div>
    <h6><i class="fas fa-bullhorn"></i>Slogan</h6>
    <textarea id="text">grün tut gut</textarea><br>
    <small>Zeilen, die mit einem<br>
        Ausrufezeichen ! beginnen,<br>
        werden hervorgehoben</small>
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
