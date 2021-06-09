<h3 class="collapsed" data-toggle="collapse" data-target=".picture"><i class="fas fa-image"></i> Bild</h3>
<div class="picture collapse list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 d-flex justify-content-between">
        <a href="#" class="text-primary cursor-pointer uploadfileclicker">
            <i class="fa fa-upload"></i> Bild oder Video hochladen
        </a> 
        <input type="hidden" name="backgroundcolor" id="backgroundcolor" value="#A0C864">
        <span class="colorpicker ms-1" data-colors="#000000,#A0C864,#145F32" data-action="background.drawColor()" data-field="#backgroundcolor" title="Bild löschen und Hintergrundfarbe setzen"></span> 
    </div>
    <?php if(configValue("Features","showMediaGallery")){ ?>
        <div class="d-flex justify-content-between mb-1">
            <a href="#"  class="overlay-opener" data-target="pictureoverlay" title="Bild aus der internen Mediengalerie auswählen" class="">
                <i class="fas fa-image"></i> Mediengalerie
            </a>
        </div>
    <?php } ?>
    <div>
        <div class="input-group -select-type">
            <div class="input-group-prepend">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-images imagedb-selected-type"></i>
                </button>
                <div class="dropdown-menu">
                    <span class="dropdown-item imagedb-search-in" data-icon="images" data-files="pixabay-images"><i class="fas fa-images"></i> Pixabay</span>
                    <span class="dropdown-item imagedb-search-in" data-icon="images" data-files="pexels-images"><i class="fas fa-images"></i> Pexels</span>
                    <span class="dropdown-item imagedb-search-in" data-icon="images" data-files="unsplash-images"><i class="fas fa-images"></i> Unsplash</span>
                    <span class="dropdown-item imagedb-search-in" data-icon="video" data-files="pixabay-video"><i class="fas fa-video"></i> Videos</span>
                </div>
            </div>

            <input type="text" class="form-control" id="imagedb-direct-search-q" placeholder="Suchbegriff">
            <div class="input-group-append">
                <button type="button" class="input-group-text btn-group imagedb-direct-search">suchen</button>
            </div>
        </div>
    </div>
    
    <div class="mt-2 mb-1 list-group-item-content show preferences-pic novideo">
        <div class="slider novideo">
            <small>klein</small>
            <input type="range" class="form-range" name="backgroundsize" id="backgroundsize" min="1"
                    max="1500" value="1200">
            <small>groß</small>
        </div>

        <div class="slider novideo">
            <small>schwarzweiß</small>
            <input type="range" class="form-range" name="graybackground" id="graybackground" min="0"
                max="1" value="1" step="0.05">
            <small>farbig</small>
        </div>

        <div class="slider novideo">
            <small>scharf</small>
            <input type="range" class="form-range" name="blurbackground" id="blurbackground" min="0"
                max="10" value="0" step="0.5">
            <small>unscharf</small>
        </div>

        <div class="slider novideo">
            <small>hell</small>
            <input type="range" class="form-range" name="darklightlayer" id="darklightlayer" min="-60"
                max="60" value="0" step="5">
            <small>dunkel</small>
        </div>

        <div class="slider novideo">
            <small>unverändert</small>
            <input type="range" class="form-range" name="greenlayer" id="greenlayer" min="0"
                max="100" value="0" step="5">
            <small>grün</small>
        </div>

        <small class="text-primary cursor-pointer novideo" id="backgroundreset"><i class="fas fa-align-center"></i>
            zentrieren
        </small>
        <small class="text-primary cursor-pointer novideo ms-5" id="backgroundflip"><i class="fas fa-exchange-alt"></i>
            spiegeln
        </small>
    </div>
    <div class="align-items-lg-center show-copyright d-none">
        <div class="d-flex align-items-center">

            <input type="text" placeholder="Bildnachweise" name="copyright" id="copyright" value="" class="form-control">
            <span class="colorpicker ms-1" data-colors="#ffffff,#000000,#009571,#46962b,#E6007E,#FEEE00" data-action="copyright.draw()" data-field="#copyrightcolor" title="Farbe wechseln"></span> 

        </div>
    </div>
</div>   
<input type="hidden" name="backgroundX" id="backgroundX">
<input type="hidden" name="backgroundY" id="backgroundY">
<input type="hidden" name="backgroundURL" id="backgroundURL">
<input type="hidden" name="backgroundFlipped" id="backgroundFlipped" value="false">
<input type="hidden" name="fullBackgroundName" id="fullBackgroundName">
<input type="hidden" name="copyrightcolor" id="copyrightcolor" value="white">
<input type="file" class="custom-file-input upload-file" id="uploadfile" accept="image/*,.heic,video/mp4">