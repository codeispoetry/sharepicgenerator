<form id="pic">
    <div class="list-group">
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
                            <?php
                            $sizes = parse_ini_file('picturesizes.ini', TRUE);
                            foreach ($sizes AS $name => $group) {
                                printf('<optgroup label="%s">', $name);
                                foreach ($group AS $label => $size) {
                                    list($width, $height) = preg_split("/[^0-9]/", trim($size));
                                    printf('<option value="%d:%d">%s</option>', $width, $height, $label);
                                }
                                echo '</optgroup>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>


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
                <div class="">
                    <input type="text" placeholder="Text über der Linie" name="textbefore" id="textbefore" value=""
                           class="form-control">
                </div>
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control"></textarea>
                </div>
                <div class="">
                    <input type="text" placeholder="Text unter der Linie" name="textafter" id="textafter" value=""
                           class="form-control">
                </div>
                <small>Text in eckigen Klammern [ ] wird gelb</small>

                <div class="mb-1 mt-2">
                    <div class="slider">
                        <small>klein</small>
                        <input type="range" class="custom-range" name="textsize" id="textsize" min="1" max="100">
                        <small>groß</small>
                    </div>
                </div>
               
                <div class="mb-1 mt-2">
                    <label>
                        <input type="checkbox" name="textsamesize" id="textsamesize">
                        Alle Zeilen gleich lang
                    </label>
                </div>
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">Störer</h6>
                <small class="text-primary cursor-pointer pinreset"><i class="fas fa-undo-alt"></i>
                    in die Mitte setzen</small>

            </div>
            <div class="mb-1 list-group-item-content">
                <div class="mb-1 list-group-item-content">
                    <input type="text" name="pintext" id="pintext" placeholder="Störertext" value=""
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start d-none">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">Zeile unten</h6>
            </div>
            <div class="mb-1 list-group-item-content">
                <input type="text" placeholder="Text für die Zeile unten" name="subline" id="subline" value=""
                       class="form-control">
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">Logo</h6>
            </div>
            <div class="mb-1 list-group-item-content">
                <select class="form-control" id="logoselect">
                    <option value="sonnenblume">Sonnenblume</option>
                    <option value="sonnenblume-weiss">Weiße Sonnenblume</option>
                    <option value="logo-weiss">Logo in weiß</option>
                    <option value="logo-gruen">Logo in grün
                        <nav></nav>
                    </option>
                    <option value="sonnenblume-big">Sonnenblume links unten</option>
                </select>
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">Design</h6>
            </div>
            <div class="mb-1 list-group-item-content">
                <select class="form-control" id="design">
                    <option value="standard">Standard</option>
                    <option value="textbackground">Grün hinter dem Text</option>
                    <KILLoption value="bigright">Großfläche</option>
                </select>
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