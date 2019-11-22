<div class="list-group">
    <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1">Eigenes Bild</h6>
            <small></small>
        </div>
        <div class="mb-1 list-group-item-content">
            <div class="custom-file" id="upload">
                <input type="file" class="custom-file-input" id="uploadfile" accept="image/*">
                <label class="custom-file-label" for="uploadfile">Datei wählen</label>
                <div class="message"></div>
            </div>
            <div><small>oder</small></div>
            <a href="#" class="text-secondary cursor-pointer" id="pixabayopener">Bilder suchen</a>
        </div>
        <small></small>
    </div>

    <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1">Text</h6>
            <small></small>
        </div>
        <div class="list-group-item-content">
            <div class="mb-1">
                <textarea id="text" class="form-control">grün tut gut</textarea>
            </div>
            <small>Zeilen, die mit einem
                Ausrufezeichen ! beginnen,
                werden hervorgehoben</small>

            <div class="mb-1 mt-2">
                <div class="slider">
                    <small>klein</small>
                    <input type="range" class="custom-range" id="textsize" min="1" max="100">
                    <small>groß</small>
                </div>
            </div>
            <small></small>
        </div>
    </div>

    <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1">Pin</h6>
            <small></small>
        </div>
        <div class="mb-1 list-group-item-content">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="custom-range" id="pinsize" min="1" max="100">
                <small>groß</small>
            </div>
        </div>
    </div>

    <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1">Zeile unten</h6>
        </div>
        <div class="mb-1 list-group-item-content">
            <input type="text" id="subline" value="gruene-bayern.de" class="form-control">
        </div>
    </div>

    <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1">Ausgabegröße</h6>
            <small class="text-primary cursor-pointer" id="sizereset"><i class="fas fa-undo-alt"></i>
                zurücksetzen</small>

        </div>
        <div class="mb-1 list-group-item-content">
            <div class="form-inline">
                <input type="number" class="form-control size" id="width" step="10"><span class="m-1">x</span>
                <input type="number" class="form-control size mr-1" id="height" step="10"> Pixel
            </div>
        </div>
    </div>

    <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1">Hintergrundbild</h6>
            <small class="text-primary cursor-pointer" id="backgroundreset"><i class="fas fa-undo-alt"></i> zurücksetzen</small>
        </div>
        <div class="mb-1 list-group-item-content">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="custom-range" id="backgroundsize" min="1" max="1500" value="1200">
                <small>groß</small>
            </div>
        </div>
    </div>

</div>

<div>
    <input type="hidden" id="pinX">
    <input type="hidden" id="pinY">
    <input type="hidden" id="backgroundX">
    <input type="hidden" id="backgroundY">
    <input type="hidden" id="textX">
    <input type="hidden" id="textY">
</div>
