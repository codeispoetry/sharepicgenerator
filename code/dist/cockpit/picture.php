<h3><i class="fas fa-image"></i> Eigenes Bild</h3>
<div class="picture  list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 d-flex justify-content-between">
        <span class="btn btn-cockpit cursor-pointer uploadfileclicker">
            <i class="fa fa-upload"></i> Bild oder Video hochladen
        </span> 
        <input type="hidden" name="backgroundcolor" id="backgroundcolor" value="#A0C864">
        <span class="colorpicker ms-1" data-colors="#A0C864,#145F32" data-action="background.drawColor()" data-field="#backgroundcolor" title="Bild löschen und Hintergrundfarbe setzen"></span> 
    </div>
 </div>
 <h3><i class="fas fa-image"></i> Bild suchen</h3>
 <div class="picture  list-group-item list-group-item-action flex-column align-items-start">  
    <div>
        <div class="input-group -select-type">
            <div class="input-group-prepend">
                <button class="btn btn-outline-cockpit dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-images imagedb-selected-type"></i>
                </button>
                <div class="dropdown-menu">
                    <span class="dropdown-item imagedb-search-in" data-icon="images" data-files="pixabay-images"><i class="fas fa-images"></i> Pixabay</span>
                    <span class="dropdown-item imagedb-search-in" data-icon="video" data-files="pixabay-video"><i class="fas fa-video"></i> Videos</span>
                </div>
            </div>

            <input type="text" class="form-control" id="imagedb-direct-search-q" placeholder="Suchbegriff">
            <div class="input-group-append">
                <button type="button" class="input-group-text btn-group imagedb-direct-search">suchen</button>
            </div>
        </div>
    </div>
</div>

<h3><i class="fas fa-image"></i> Bildeinstellungen</h3>
<div class="picture  list-group-item list-group-item-action flex-column align-items-start">

    <div class="mt-2 mb-1 list-group-item-content show preferences-pic novideo">
        <div class="slider novideo">
            <small>klein</small>
            <input type="range" class="form-range" name="backgroundsize" id="backgroundsize" min="1"
                    max="1500" value="1200">
            <small>groß</small>
        </div>

        <div class="slider novideo">
            <small>schwarzweiß</small>
            <input type="range" class="form-range" name="saturate" id="saturate" min="0"
                max="1" value="1" step="0.05">
            <small>farbig</small>
        </div>

        <div class="slider novideo">
            <small>scharf</small>
            <input type="range" class="form-range" name="blur" id="blur" min="0"
                max="8" value="0" step="0.25">
            <small>unscharf</small>
        </div>

        <div class="slider novideo">
            <small>dunkel   </small>
            <input type="range" class="form-range" name="brightness" id="brightness" min="0.4"
                max="1.6" value="1" step="0.1">
            <small>hell</small>
        </div>
 
        <div>
            <small class="text-cockpit cursor-pointer novideo me-5" id="backgroundflip"><i class="fas fa-exchange-alt"></i>
                spiegeln
            </small>
            <small class="text-cockpit cursor-pointer novideo" id="backgroundreset"><i class="fas fa-undo"></i></i>
                zurücksetzen
            </small>
        </div>

        
    </div>
    <div class="align-items-lg-center show-copyright d-none">
        <div class="d-flex align-items-center">

            <input type="text" placeholder="Bildnachweise" name="copyright" id="copyright" value="" class="form-control">
            <span class="colorpicker ms-1" data-colors="#ffffff,#000000,#009571,#46962b,#E6007E,#FEEE00" data-action="copyright.draw()" data-field="#copyrightcolor" title="Farbe wechseln"></span> 

        </div>
    </div>

</div>   

<h3 class="d-none"><i class="fas fa-image"></i> Grünfärbung</h3>
<div class="list-group-item novideo d-none">
        Bild grün einfärben
        <input type="checkbox" name="greenify" class="retoggle" id="greenify" data-size="xs" data-bs-toggle="toggle" data-on="ja" data-off="nein">

        <div class="slider novideo">
            <small>Helligkeit</small>
            <input type="range" class="form-range" name="greenifybrightness" id="greenifybrightness" min="0.5"
                max="10" value="2.5" step="0.5">
        </div>

        <div class="slider novideo">
            <small>Kontrast</small>
            <input type="range" class="form-range" name="greenifycontrast" id="greenifycontrast" min="0"
                max="0.8" value="0.05" step="0.005">
        </div>
        <small class="text-cockpit cursor-pointer novideo greenifyreset">
            <i class="fas fa-undo"></i> Helligkeit und Kontrast zurücksetzen
        </small>

</div>


<input type="hidden" name="backgroundX" id="backgroundX">
<input type="hidden" name="backgroundY" id="backgroundY">
<input type="hidden" name="backgroundURL" id="backgroundURL">
<input type="hidden" name="backgroundFlipped" id="backgroundFlipped" value="false">
<input type="hidden" name="fullBackgroundName" id="fullBackgroundName">
<input type="hidden" name="copyrightcolor" id="copyrightcolor" value="white">
<input type="file" class="custom-file-input upload-file" id="uploadfile" accept="image/*,.heic,video/mp4">