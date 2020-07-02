<form id="pic">
    <div class="list-group">

        <h3 class="" data-toggle="collapse" data-target=".picture">Bild</h3>
        <div class="picture show list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex justify-content-between mb-1">
                <a href="#" class="text-primary cursor-pointer uploadfileclicker">
                    <i class="fa fa-upload"></i> Hintergrundbild/ -video hochladen
                </a>
                
                <span class="text-primary cursor-pointer" id="pixabayopener">
                    <i class="fas fa-search"></i> suchen
                </span>
            </div>
            <small class="collapsed cursor-pointer text-primary preferences-pic-btn" data-toggle="collapse" data-target=".preferences-pic" aria-expanded="false" aria-controls="collapsePreferecesPic">
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

            <div class="flex-column align-items-start">
                <?php for($i = 1; $i <=2; $i++){ ?>
                    <div class="mb-1 list-group-item-content <?php if($i > 1) echo 'show-add-pic-upload d-none'; ?>">
                        <div class="d-flex w-100 justify-content-between">
                         <span class="text-primary cursor-pointer addpicclicker<?php echo $i;?>">
                            <i class="fa fa-upload"></i> <?php echo $i;?>. Vordergrundbild hochladen
                        </span>

                            <?php if($i == 2 ){?>
                                <small class="text-primary cursor-pointer d-none show-add-pic-<?php echo $i;?>" id="addpicalign" data-click="addpicAlign">
                                    <i class="fas fa-align-justify"></i>
                                    angleichen
                                </small>
                            <?php } ?>

                            <small class="text-primary cursor-pointer d-none show-add-pic-<?php echo $i;?>" id="addpicdelete<?php echo $i;?>">
                                <i class="fas fa-trash"></i>
                                löschen
                            </small>
                        </div>
                        <div class="mb-1 mt-2 d-none show-add-pic-<?php echo $i;?>">
                            <div class="d-flex align-items-center">
                               <div class="slider">
                                    <small>klein</small>
                                    <input type="range" class="custom-range" name="addPicSize<?php echo $i;?>" id="addPicSize<?php echo $i;?>" min="1" max="100" value="15">
                                    <small>groß</small>
                                </div>
                                <div class="ml-3">
                                    <label>
                                        <input type="checkbox" name="addpicrounded<?php echo $i;?>" id="addpicrounded<?php echo $i;?>" data-size="xs" data-toggle="toggle" data-on="rund" data-off="eckig">
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php } ?>
            </div>
            <div class="align-items-lg-center show-copyright d-none">
                <div class="d-flex align-items-center">
                    <input type="hidden" name="copyrightPosition" id="copyrightPosition"  value="bottomLeft">

                    <input type="text" placeholder="Bildnachweise" name="copyright" id="copyright" value="" class="form-control">
                    <i class="fa fa-broom ml-1 text-primary cursor-pointer copyright-change-color ml-1" title="Farbe wechseln"></i>
                </div>
            </div>
         </div>

        <h3 class="collapsed" data-toggle="collapse" data-target=".layout">Ausgabegröße</h3>
        <div class="layout collapse list-group-item list-group-item-action flex-column align-items-start novideo">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <div class="form-inline">
                    <div class="form-row sizecontainer">
                        <input type="number" class="form-control size" name="width" id="width" step="10">
                        <span class="mt-2 small">x</span>
                        <input type="number" class="form-control size" name="height" id="height" step="10">
                        <span class="mt-2 mr-2 small">Px</span>

                        <select class="form-control" id="sizepresets">
                            <option class="">Vorgabe</option>
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
                <small class="text-primary cursor-pointer" id="sizereset"><i class="fas fa-undo-alt"></i> zurücksetzen</small>
            </div>
        </div>

        <h3 class="" data-toggle="collapse" data-target=".text">Text</h3>
        <div class="text show list-group-item list-group-item-action flex-column align-items-start">
            <div class="list-group-item-content mb-2">

                <select class="form-control" name="layout" id="layout">
                    <option value="standard">Layout: Standard</option>
                    <option value="quote">Layout: Zitat</option>
                </select>
            </div>

            <div class="list-group-item-content">
                <div class="noquote">
                    <input type="text" placeholder="Text über der Linie" name="textbefore" id="textbefore" value=""
                           class="form-control">
                </div>
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control"></textarea>
                </div>
                <div class="d-flex align-items-lg-center">
                    <input type="text" placeholder="Text unter der Linie" name="textafter" id="textafter" value="" class="form-control">
                    <div class="d-none noquote">
                        <i class="fa fa-broom ml-1 text-primary cursor-pointer text-change-color ml-1" data-click="textChangeColor" title="Farbe wechseln"></i>
                    </div>
                </div>

                <div class="mb-1 mt-2">
                    <div class="d-flex justify-content-between mt-3">
                        <small>Text in eckigen Klammern [ ] wird gelb</small>
                        <small class="cursor-pointer ml-3 text-primary aligncenter">
                            <i class="fa fa-align-center"></i>
                            mittig ausrichten</small>
                    </div>
                </div>


                <div class="mb-1 mt-2">
                    <div class="slider">
                        <small>klein</small>
                        <input type="range" class="custom-range" name="textsize" id="textsize" min="1" max="100">
                        <small>groß</small>
                    </div>
                </div>

                <div class="preferences-text">
                    <div class="d-flex justify-content-between">
                        <div class="noquote">
                            <label>
                                <input type="checkbox" name="textsamesize" id="textsamesize">
                                Zeilen gleich lang
                            </label>
                            <label>
                                <input type="checkbox" name="greenbehindtext" id="greenbehindtext">
                                Grün hinter Text
                            </label>
                        </div>
                        <label>
                            <input type="checkbox" name="graybehindtext" id="graybehindtext">
                            Grau hinter Text
                        </label>
                    </div>
                </div>    
            </div>
            <div class="noquote preferences-text">
                <div class="d-flex justify-content-between mt-3">
                    <span class="text-primary cursor-pointer uploadiconclicker">
                        <i class="fa fa-upload"></i> Icon hochladen
                    </span>
                    
                    <span class="text-primary cursor-pointer" id="iconopener">
                        <i class="fas fa-search"></i> Icon suchen
                    </span>
                </div>
                <div class="mb-1 list-group-item-content d-none iconsizeselectwrapper">
                    <select class="form-control" name="iconsize" id="iconsize">
                        <option value="1">Icon: 1 Zeile hoch</option>
                        <option value="2">Icon: 2 Zeilen hoch</option>
                        <option value="3">Icon: 3 Zeilen hoch</option>
                        <option value="0">Icon entfernen</option>
                    </select>
                </div>
            </div>    
        </div>

        <h3 class="collapsed" data-toggle="collapse" data-target=".eyecatcher">Störer</h3>
        <div class="eyecatcher list-group-item list-group-item-action flex-column align-items-start collapse">
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
        </div>

        <h3 class="collapsed" data-toggle="collapse" data-target=".logo">Logo</h3>
        <div class="logo collapse list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 d-flex align-items-lg-center">
                <select class="form-control" name="logoselect" id="logoselect">
                    <optgroup label="Sonnenblume">
                        <option value="sonnenblume">Sonnenblume</option>
                        <option value="sonnenblume-weiss">weiße Sonnenblume</option>
                        <option value="sonnenblume-big">Sonnenblume links unten</option>
                    </optgroup>
                    <optgroup label="Logo mit Schriftzug">
                        <option value="logo-weiss">weiß, mit Schriftzug</option>
                        <option value="logo-gruen">grün, mit Schriftzug</option>
                    </optgroup>
                    
                    <?php
                        if( $landesverband == 3 ){
                    ?>
                    <optgroup label="Berlin">
                        <option value="logo-berlin-gruen">Berliner Logo in grün</option>
                        <option value="logo-berlin-weiss" selected>Berliner Logo in weiß</option>
                    </optgroup>
                    <?php
                        }
                    ?>
                    <optgroup label="Eigenes Logo">
                    <?php
                        if( file_exists('../persistent/user/' . $user . '/logo.png') ){
                    ?>
                        <option value="custom" selected>eigenes Logo</option>
                        <option value="deletecustomlogo">eigenes Logo löschen</option>
                   <?php
                        }else{
                            echo '<option value="custom">eigenes Logo hochladen</option>';
                        }
                    ?>
                    </optgroup>
                    <optgroup label="Speziallogos">
                        <option value="frauenrechte">Frauenrechte</option>
                        <option value="regenbogen">Regenbogen</option>
                        <option value="europa">Europa</option>
                    </optgroup>
                    <optgroup label="Kein Logo">
                        <option value="void">kein Logo</option>
                    </optgroup>
                </select>
                 <i class="fa fa-upload text-primary cursor-pointer uploadlogoclicker ml-2" title="Eigenes Logo hochladen"></i>
                
            </div>
            <div class="">
                Erstelle Dein OV-Logo mit dem <a href="/logo" target="_blank">Logogenerator</a>.
            </div>
        </div>

        <h3 class="collapsed" data-toggle="collapse" data-target=".screen">Screen</h3>
        <div class="screen collapse list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 align-items-center">
                <span class="mr-2">Hintergrund:</span>
               <input id="color-scheme" type="checkbox" data-width="60" data-size="xs" data-toggle="toggle" data-on="dunkel" data-off="hell">
                <span class="ml-5 mr-2">Hilflinien:</span>
               <input id="gridlines" type="checkbox" data-width="40" data-size="xs" data-toggle="toggle" data-on="an" data-off="aus">
            </div>
        </div>

        <h3 class="collapsed" data-toggle="collapse" data-target=".cloud">Wolke</h3>
        <div class="cloud collapse list-group-item list-group-item-action flex-column align-items-start">
            <div>
                <a href="https://wolke.netzbegruenung.de/apps/files/?dir=/sharepicgenerator" target="_blank">
                    Meine Wolke
                </a>
            </div>
            <div>
                <button type="button" class="btn btn-info btn-sm download"  data-cloud="save"><i class="fas fa-cloud-download-alt"></i> in Cloud speichern</button>
            </div>
        </div>

        <h3 class="collapsed" data-toggle="collapse" data-target=".finish">Arbeitsdatei</h3>
        <div class="finish collapse list-group-item list-group-item-action flex-column align-items-start">
            <div>
                <button type="button" class="btn btn-info btn-sm" id="savework" data-click="savework"><i class="fas fa-download"></i> Arbeitsdatei herunterladen</button>
                <button type="button" class="btn btn-info btn-sm uploadworkclicker" id="uploadworkclicker"><i class="fas fa-upload"></i> hochladen</button>
            </div>
        </div>
        <div class="mt-1">
            <button type="button" class="btn btn-secondary btn-lg download"><i class="fas fa-download"></i> Sharepic herunterladen</button>
        </div>
    </div>
    <div class="d-none">
        <input type="hidden" name="pinX" id="pinX">
        <input type="hidden" name="pinY" id="pinY">
        <input type="hidden" name="backgroundX" id="backgroundX">
        <input type="hidden" name="backgroundY" id="backgroundY">
        <input type="hidden" name="backgroundURL" id="backgroundURL">
        <input type="hidden" name="iconfile" id="iconfile">
        <input type="hidden" name="addpicfile1" id="addpicfile1">
        <input type="hidden" name="addpicfile2" id="addpicfile2">
        <input type="hidden" name="fullBackgroundName" id="fullBackgroundName">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="addPic1x" id="addPic1x">
        <input type="hidden" name="addPic1y" id="addPic1y">
        <input type="hidden" name="addPic2x" id="addPic2x">
        <input type="hidden" name="addPic2y" id="addPic2y">
        <input type="hidden" name="textColor" id="textColor" value="0">

        <input type="file" class="custom-file-input upload-file" id="uploadfile" accept="image/*,video/mp4">
        <input type="file" class="custom-file-input upload-file" id="uploadlogo" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadaddpic1" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadaddpic2" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadwork" accept="application/zip">
    </div>
</form>