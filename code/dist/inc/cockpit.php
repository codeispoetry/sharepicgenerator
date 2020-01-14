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
            <div class="d-flex justify-content-between mb-1">
                <a href="#" class="text-primary cursor-pointer uploadfileclicker">
                    <i class="fa fa-upload"></i> Bild oder Video hochladen
                </a>
                
                <a href="#" class="text-primary cursor-pointer" id="pixabayopener">
                    <i class="fa fa-images"></i> suchen
                </a>
                
                <a href="#" class="text-primary cursor-pointer d-none" id="templateopener">
                    <i class="fa fa-thumbs-up"></i> Vorlagen
                </a>
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
            <div class="h-0" id="upload">
                 <input type="file" class="custom-file-input upload-file" id="uploadfile" accept="image/*,video/*">
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
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
               
                <div class="d-flex justify-content-between">
                    <label>
                        <input type="checkbox" name="textsamesize" id="textsamesize">
                        Zeilen gleich lang
                    </label>
                    <label>
                        <input type="checkbox" name="greenbehindtext" id="greenbehindtext">
                        Grün hinter Text
                    </label>
                </div>
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <a href="#" class="text-primary cursor-pointer" id="iconopener">
                <i class="fa fa-images"></i> Icon suchen
            </a>
            <div class="mb-1 list-group-item-content d-none iconsizeselectwrapper">
                <select class="form-control" id="iconsize">
                    <option value="1">Icon: 1 Zeile hoch</option>
                    <option value="2">Icon: 2 Zeilen hoch</option>
                    <option value="3">Icon: 3 Zeilen hoch</option>
                    <option value="0">Icon entfernen</option>
                </select>
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 list-group-item-content">
                <div class="d-flex align-items-lg-center">
                    <textarea name="pintext" id="pintext" placeholder="Störertext. Maximal 2 Zeilen." value="" class="form-control"></textarea>
                    <i class="fas fa-undo-alt text-primary cursor-pointer pinreset ml-1" title="Störer in die Mitte setzen"></i>
                </div>
                <div class="slider">
                    <small>klein</small>
                    <input type="range" class="custom-range" name="eyecatchersize" id="eyecatchersize" min="50"
                           max="300" value="100">
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
                <select class="form-control" id="logoselect">
                    <optgroup label="Sonnenblume">
                        <option value="sonnenblume">Logo: Sonnenblume</option>
                        <option value="sonnenblume-weiss">Logo: Weiße Sonnenblume</option>
                        <option value="sonnenblume-big">Logo: Sonnenblume links unten</option>
                    </optgroup>
                    <optgroup label="Standardlogo">
                        <option value="logo-weiss">Logo: weiß</option>
                        <option value="logo-gruen">Logo: grün</option>
                    </optgroup>
                    
                    <?php
                        if( $landesverband == 3 ){
                    ?>
                    <optgroup label="Berlin">
                        <option value="logo-berlin-gruen">Logo Berlin: grün</option>
                        <option value="logo-berlin-weiss" selected>Logo Berlin: weiss</option>
                    </optgroup>
                    <?php
                        }
                    ?>

                    <?php
                        if( file_exists('persistent/user/' . $user . '/logo.png') ){
                            echo '<option value="custom" selected>eigenes Logo</option>';
                        }else{
                            echo '<option value="custom">eigenes Logo hochladen</option>';
                        }
                    ?>

                    <option value="void">kein Logo</option>
                </select>
          
                 <i class="fa fa-upload text-primary cursor-pointer uploadlogoclicker ml-2" title="Eigenes Logo hochladen"></i>
              
            </div>

            <div class="h-0">
                <input type="file" class="custom-file-input upload-file" id="uploadlogo" accept="image/*">
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