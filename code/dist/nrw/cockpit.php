<form id="pic">
    <div class="list-group">

        <h3 class="" data-toggle="collapse" data-target=".picture">Bild</h3>
        <div class="picture show list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex justify-content-between mb-1">
                <a href="#" class="text-primary cursor-pointer uploadfileclicker">
                    <i class="fa fa-upload"></i> Bild/Video hochladen
                </a>

                <span class="text-primary cursor-pointer" id="pixabayopener">
                    <i class="fas fa-search"></i> suchen
                </span>
            </div>
            <small class="cursor-pointer text-primary preferences-pic-btn" data-toggle="collapse" data-target=".preferences-pic" aria-expanded="false" aria-controls="collapsePreferecesPic">
               Bildeinstellungen
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

            <div class="addpics flex-column align-items-start">
                <?php for($i = 1; $i <=2; $i++){ ?>
                    <div class="mb-1 list-group-item-content">
                        <div class="d-flex w-100 justify-content-between">
                         <span class="text-primary cursor-pointer addpicclicker<?php echo $i;?>">
                            <i class="fa fa-upload"></i> <?php echo $i;?>. Zusatzbild (Portrait) hochladen
                        </span>
                            <small class="text-primary cursor-pointer" id="addpicdelete<?php echo $i;?>"><i class="fas fa-trash"></i>
                                löschen</small>
                        </div>
                        <div class="mb-1 mt-2">
                            <div class="slider">
                                <small>klein</small>
                                <input type="range" class="custom-range" name="addPicSize<?php echo $i;?>" id="addPicSize<?php echo $i;?>" min="1" max="100" value="15">
                                <small>groß</small>
                                <div class="ml-3">
                                    <label>
                                        <input type="checkbox" name="addpicrounded<?php echo $i;?>" id="addpicrounded<?php echo $i;?>" data-size="xs" data-toggle="toggle" data-on="eckig" data-off="rund">
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php } ?>
            </div>


            <div class="d-flex align-items-lg-center">
                <input type="hidden" name="copyrightPosition" id="copyrightPosition" value="upperLeft">
                <input type="text" placeholder="Bildnachweis" name="copyright" id="copyright" value="" class="form-control">
                <i class="fa fa-broom ml-1 text-primary cursor-pointer copyright-change-color ml-1" title="Farbe wechseln"></i>
            </div>
        </div>

        <h3 class="collapsed" data-toggle="collapse" data-target=".layout">Ausgabegröße</h3>
        <div class="layout collapse list-group-item list-group-item-action flex-column align-items-start novideo">
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

        <h3 class="" data-toggle="collapse" data-target=".text">Text</h3>
        <div class="text show list-group-item list-group-item-action flex-column align-items-start">
            <div class="list-group-item-content">
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control"></textarea>
                </div>
                <div class="d-flex align-items-lg-center">

                </div>

                <div class="">
                    <small>Zeilen, die mit einem ! beginnen, werden hervorgehoben</small>
                </div>
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-change-color cursor-pointer text-primary" data-id="1" >
                            <i class="fa fa-broom"  title="Hauptfarbe wechseln"></i>
                            Hauptfarbe wechseln
                        </span>
                        <span class="text-change-color cursor-pointer text-primary" data-id="2" >
                            <i class="fa fa-broom"  title="Zweitfarbe wechseln"></i>
                            Zweitfarbe wechseln
                        </span>
                    </div>
                </div>

                <div class="mb-1 mt-2">
                    <div class="slider">
                        <small>klein</small>
                        <input type="range" class="custom-range" name="textsize" id="textsize" min="1" max="100">
                        <small>groß</small>
                    </div>


                </div>
               

            </div>
        </div>

        <h3 class="collapsed" data-toggle="collapse" data-target=".logo">Logo</h3>
        <div class="logo collapse list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 d-flex align-items-lg-center">
                <select class="form-control" name="logoselect" id="logoselect">
                    <option value="sonnenblume">Logo: Sonnenblume</option>
                    <option value="sonnenblume-weiss">Logo: Weiße Sonnenblume</option>
                </select>
                </div>

        </div>


        <h3 class="collapsed" data-toggle="collapse" data-target=".screen">Screen</h3>
        <div class="screen collapse list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 d-flex align-items-lg-center">
                <span class="mr-2">Hintergrund:</span>
               <input id="color-scheme" type="checkbox" data-size="xs" data-toggle="toggle" data-on="dunkel" data-off="hell">
                <span class="ml-5 mr-2">Hilflinien:</span>
               <input id="gridlines" type="checkbox" data-size="xs" data-toggle="toggle" data-on="an" data-off="aus">
            </div>
        </div>


        <div class="mt-1">
            <button type="button" class="btn btn-secondary btn-lg download"><i class="fas fa-download"></i> Sharepic herunterladen</button>
        </div>

    </div>
    <div class="d-none">
        <input type="file" class="custom-file-input upload-file" id="uploadfile" accept="image/*,video/mp4">
        <input type="file" class="custom-file-input upload-file" id="uploadlogo" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadaddpic1" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadaddpic2" accept="image/*">
        <input type="hidden" name="backgroundX" id="backgroundX">
        <input type="hidden" name="backgroundY" id="backgroundY">
        <input type="hidden" name="backgroundURL" id="backgroundURL">
        <input type="hidden" name="iconfile" id="iconfile">
        <input type="hidden" name="addpicfile1" id="addpicfile1">
        <input type="hidden" name="addpicfile2" id="addpicfile2">
        <input type="hidden" name="fullBackgroundName" id="fullBackgroundName">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="addPicX" id="addPicX">
        <input type="hidden" name="addPicY" id="addPicY">
        <input type="hidden" name="textColor1" id="textColor1" value="2">
        <input type="hidden" name="textColor2" id="textColor2" value="0">
    </div>

</div>
</form>