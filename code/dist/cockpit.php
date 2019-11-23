<form id="pic">
    <div class="list-group">
        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">Bild</h6>
                <small></small>
            </div>
            <div class="mb-1 list-group-item-content">
                <div class="" id="upload">
                    <input type="file" class="custom-file-input" id="uploadfile" accept="image/*">
                </div>
                <a href="#" class="text-primary cursor-pointer uploadfileclicker">Eigenes Bild hochladen</a>
                <small>oder</small>
                <a href="#" class="text-primary cursor-pointer" id="pixabayopener">Bild suchen</a>
            </div>


            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1"></h6>
                <small class="text-primary cursor-pointer" id="backgroundreset"><i class="fas fa-align-center"></i>
                    zentrieren</small>
            </div>
            <div class="mb-1 list-group-item-content">
                <div class="slider">
                    <small>klein</small>
                    <input type="range" class="custom-range" name="backgroundsize" id="backgroundsize" min="1"
                           max="1500" value="1200">
                    <small>groß</small>
                </div>
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">Text</h6>
                <small></small>
            </div>
            <div class="list-group-item-content">
                <div class="mb-1">
                    <textarea name="text" id="text" class="form-control">grün tut gut</textarea>
                </div>
                <small>Zeilen, die mit einem
                    Ausrufezeichen ! beginnen,
                    werden hervorgehoben</small>

                <div class="mb-1 mt-2">
                    <div class="slider">
                        <small>klein</small>
                        <input type="range" class="custom-range" name="textsize" id="textsize" min="1" max="100">
                        <small>groß</small>
                    </div>
                </div>
                <small></small>
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">Pin</h6>
            </div>
            <div class="mb-1 list-group-item-content">
                <div class="slider">
                    <small>klein</small>
                    <input type="range" class="custom-range" name="pinsize" id="pinsize" min="1" max="100">
                    <small>groß</small>
                </div>
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">Zeile unten</h6>
            </div>
            <div class="mb-1 list-group-item-content">
                <input type="text" name="subline" id="subline" value="gruene-bayern.de" class="form-control">
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
                    <div class="form-row sizecontainer">
                        <input type="number" class="form-control size" name="width" id="width" step="10">
                        <span class="m-1">x</span>
                        <input type="number" class="form-control size mr-1" name="height" id="height" step="10">
                        <span class="m-1 mr-3">Pixel</span>

                        <select class="form-control fas" id="sizepresets">
                            <option class="fas">&#xf5cb;</option>
                            <option value="1280:720">HD</option>
                            <option value="400:400">Quadrat</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div>
        <input type="hidden" name="pinX" id="pinX">
        <input type="hidden" name="pinY" id="pinY">
        <input type="hidden" name="backgroundX" id="backgroundX">
        <input type="hidden" name="backgroundY" id="backgroundY">
        <input type="hidden" name="backgroundURL" id="backgroundURL">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
    </div>
</form>