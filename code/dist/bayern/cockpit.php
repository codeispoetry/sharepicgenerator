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
                        <select class="form-control selectpicker fas" id="sizepresets">
                            <option class="fas">&#xf5cb;</option>

                            <?php
                                $sizes = parse_ini_file('../ini/picturesizes.ini', TRUE);
                                foreach($sizes AS $name=>$group ){
                                    printf ('<optgroup label="%s">', $name);
                                    foreach($group AS $label => $size){
                                        list($width,$height) = preg_split("/[^0-9]/",trim($size));
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
                    <i class="fa fa-upload"></i> Bild/Video hochladen
                </a>
                
                <a href="#" class="text-primary cursor-pointer" id="pixabayopener">
                    <i class="fa fa-images"></i> suchen
                </a>
                
                <a href="#" class="text-primary cursor-pointer" id="templateopener">
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
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">

            <div class="list-group-item-content">
                <div class="mb-1">
                    <textarea name="text" id="text" class="form-control" rows="3">grün tut gut</textarea>
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
                <h6 class="mb-1">Zeile "Am 15. März ..."</h6>
                <i class="fa fa-broom ml-1 text-primary cursor-pointer claim-change-color ml-1" id="claim-change-color" title="Farbe wechseln"></i>
            </div>
        </div>

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex align-items-lg-center">
                <input type="text" name="subline" id="subline" value="" placeholder="Text links unten, z.B. Homepage" class="form-control">
                <i class="fa fa-broom ml-1 text-primary cursor-pointer subline-change-color ml-1" title="Farbe wechseln"></i>
            </div>

            <div class="d-flex align-items-lg-center">
                <input type="text" placeholder="Bildnachweis" name="copyright" id="copyright" value="" class="form-control">
                <i class="fa fa-broom ml-1 text-primary cursor-pointer copyright-change-color ml-1" title="Farbe wechseln"></i>
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
        <input type="hidden" name="sublineColor" id="sublineColor" value="white">
        <input type="hidden" name="claimColor" id="claimColor" value="white">
    </div>

    <div class="d-none">
        <div class="" id="upload">
            <input type="file" class="custom-file-input upload-file" id="uploadfile" accept="image/*,video/mp4">
        </div>
    </div>
</form>