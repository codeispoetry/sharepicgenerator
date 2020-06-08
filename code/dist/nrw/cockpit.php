<form id="pic">
    <div class="list-group">

    <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex justify-content-between mb-1">
                <a href="#" class="text-primary cursor-pointer uploadfileclicker">
                    <i class="fa fa-upload"></i> Bild/Video hochladen
                </a>
                
                <span class="text-primary cursor-pointer" id="pixabayopener">
                    <i class="fas fa-search"></i> suchen
                </span>
            </div>
            <small class="cursor-pointer text-primary preferences-pic-btn" data-toggle="collapse" data-target=".preferences-pic" aria-expanded="false" aria-controls="collapsePreferecesPic">
               Bildeinstellungen <i class="fa fa-caret-down"></i>
            </small>
            <div class="mb-1 list-group-item-content collapse preferences-pic">
                <div class="slider novideo">
                    <small>klein</small>
                    <input type="range" class="custom-range" name="backgroundsize" id="backgroundsize" min="1"
                           max="1500" value="1200">
                    <small>groß</small>
                </div>

                <div class="slider novideo">
                    <small>schwarzweiß</small>
                    <input type="range" class="custom-range" name="graybackground" id="graybackground" min="0"
                        max="1" value="1" step="0.05">
                    <small>farbig</small>
                </div>

                <div class="slider novideo">
                    <small>scharf</small>
                    <input type="range" class="custom-range" name="blurbackground" id="blurbackground" min="0"
                        max="10" value="0" step="0.5">
                    <small>unscharf</small>
                </div>

                <div class="slider novideo">
                    <small>hell</small>
                    <input type="range" class="custom-range" name="darklightlayer" id="darklightlayer" min="-60"
                        max="60" value="0" step="5">
                    <small>dunkel</small>
                </div>

                <div class="slider novideo">
                    <small>unverändert</small>
                    <input type="range" class="custom-range" name="greenlayer" id="greenlayer" min="0"
                        max="100" value="0" step="5">
                    <small>grün</small>
                </div>

                <small class="text-primary cursor-pointer novideo" id="backgroundreset"><i class="fas fa-align-center"></i>
                    zentrieren
                </small>
            </div>
      

    </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start novideo">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">Ausgabegröße</h6>
                <small class="text-primary cursor-pointer" id="sizereset"><i class="fas fa-undo-alt"></i>
                    zurücksetzen</small>

            </div>
            <div class="mb-1 list-group-item-content">
                <div class="form-inline">
                    <div class="form-row sizecontainer">
                        <input type="number" class="form-control size" name="width" id="width" step="10">
                        <span class="mt-2 small">x</span>
                        <input type="number" class="form-control size" name="height" id="height" step="10">
                        <span class="mt-2 mr-2 small">Px</span>

                        <select class="form-control" id="sizepresets">
                            <option class="">Größe</option>
                            <?php
                            $sizes = parse_ini_file('../ini/picturesizes.ini', TRUE);
                            foreach ($sizes AS $name => $group) {
                                printf('<optgroup label="%s">', $name);
                                foreach ($group AS $label => $size) {
                                    list($width, $height) = preg_split("/[^0-9]/", trim($size));
                                    $socialmediaplatform = preg_replace('/ /','-', "$name-$label");
                                    printf('<option value="%d:%d" data-socialmediaplatform="%s">%s</option>', $width, $height, $socialmediaplatform, $label);
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
            <div class="list-group-item-content">
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control"></textarea>
                </div>
                <div class="d-flex align-items-lg-center">
                    <div class="d-none noquote">
                        <i class="fa fa-broom ml-1 text-primary cursor-pointer text-change-color ml-1" data-click="textChangeColor" title="Farbe wechseln"></i>
                    </div>
                </div>
                <small>Zeilen, die mit einem ! beginnen, werden hervorgehoben</small>

                <div class="mb-1 mt-2">
                    <div class="slider">
                        <small>klein</small>
                        <input type="range" class="custom-range" name="textsize" id="textsize" min="1" max="100">
                        <small>groß</small>
                    </div>
                </div>
               

            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start collapse preferences-text">
            <div class="mb-1 list-group-item-content">
                <div class="d-flex align-items-lg-center">
                    <textarea name="pintext" id="pintext" placeholder="Störertext. Maximal 2 Zeilen." value="" class="form-control"></textarea>
                    <i class="fas fa-undo-alt text-primary cursor-pointer pinreset ml-1" title="Störer in die Mitte setzen"></i>
                </div>
                <div class="slider">
                    <small>klein</small>
                    <input type="range" class="custom-range" name="eyecatchersize" id="eyecatchersize" min="50"
                           max="300" value="100" disabled>
                    <small>groß</small>
                </div>
            </div>
            <div class="d-flex align-items-lg-center">
                    <input type="text" placeholder="Bildnachweis" name="copyright" id="copyright" value="" class="form-control">
                    <i class="fa fa-broom ml-1 text-primary cursor-pointer copyright-change-color ml-1" title="Farbe wechseln"></i>
                </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 d-flex align-items-lg-center">
                <select class="form-control" name="logoselect" id="logoselect">
                    <option value="sonnenblume">Logo: Sonnenblume</option>
                    <option value="sonnenblume-weiss">Logo: Weiße Sonnenblume</option>
                </select>
                </div>

        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 list-group-item-content">
                <div class="d-flex w-100 justify-content-between">
                     <span class="text-primary cursor-pointer addpicclicker">
                        <i class="fa fa-upload"></i> Zusatzbild (Portrait) hochladen
                    </span>
                    <small class="text-primary cursor-pointer" id="addpicdelete"><i class="fas fa-trash"></i>
                        löschen</small>
                </div>
                <div class="mb-1 mt-2">
                    <div class="slider">
                        <small>klein</small>
                        <input type="range" class="custom-range" name="addPicSize" id="addPicSize" min="1" max="100" value="15">
                        <small>groß</small>
                        <div class="ml-3">
                            <label>
                                <input type="checkbox" name="addpicrounded" id="addpicrounded" data-size="xs" data-toggle="toggle" data-on="eckig" data-off="rund">
                            </label>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 d-flex align-items-lg-center">
                <span class="mr-2">Hintergrund:</span>
               <input id="color-scheme" type="checkbox" data-size="xs" data-toggle="toggle" data-on="dunkel" data-off="hell">
                <span class="ml-5 mr-2">Hilflinien:</span>
               <input id="gridlines" type="checkbox" data-size="xs" data-toggle="toggle" data-on="an" data-off="aus">
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start d-none">
            <div class="mb-1 d-flex align-items-lg-center">
                <button type="button" class="btn btn-info btn-sm mr-1" id="save" data-click="save" ><i class="fas fa-save"></i> speichern</button>
                <button type="button" class="btn btn-info btn-sm mr-1 d-none" id="load" data-click="load"><i class="fas fa-folder-open"></i> öffnen</button>
                <button type="button" class="btn btn-info btn-sm d-none" id="delete" data-click="unlink"><i class="fas fa-trash-alt"></i> löschen</button>
            </div>
            <div class="saving-response text-secondary"></div>
        </div>

        <div>
            <input type="hidden" name="backgroundX" id="backgroundX">
            <input type="hidden" name="backgroundY" id="backgroundY">
            <input type="hidden" name="backgroundURL" id="backgroundURL">
            <input type="hidden" name="iconfile" id="iconfile">
            <input type="hidden" name="addpicfile" id="addpicfile">
            <input type="hidden" name="fullBackgroundName" id="fullBackgroundName">
            <input type="hidden" name="textX" id="textX">
            <input type="hidden" name="textY" id="textY">
            <input type="hidden" name="addPicX" id="addPicX">
            <input type="hidden" name="addPicY" id="addPicY">
            <input type="hidden" name="textColor" id="textColor" value="0">

        </div>


    </div>
    <div class="d-none">
        <input type="file" class="custom-file-input upload-file" id="uploadfile" accept="image/*,video/mp4">
        <input type="file" class="custom-file-input upload-file" id="uploadlogo" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadaddpic" accept="image/*">
    </div>


</form>