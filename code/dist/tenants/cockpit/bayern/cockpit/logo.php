<h3 class="">Logo</h3>
<div class="logo list-group-item list-group-item-action flex-column align-items-start showonly floating berlintext">
    
    <div class="d-flex">
        <span class="align-logo btn btn-sm btn-outline-cockpit me-4" data-place="topright">rechts oben</span>
        <span class="align-logo btn btn-sm btn-outline-cockpit me-4" data-place="bottomright">rechts unten</span>
    </div>
   
    <div class="d-none">
        <label class="" title="ändere die Größe von Logo und Störer selbstständig">
            <input id="advancedmode" type="checkbox" class="me-1 form-check-input" >
            Größe von Logo und Störer selbst steuern
        </label>
        <div class="d-flex justify-content-between">
            <div class="slider advancedmode d-none me-3">
                <small>klein</small>
                    <input type="range" class="form-range" name="logosize" id="logosize" min="1" max="100" value="20">
                <small>groß</small>
            </div>
        </div>
        <div> 
            <span class="text-cockpit cursor-pointer uploadlogoclicker">
                <i class="fa fa-upload"></i> Eigenes Logo hochladen
            </span>
        </div>  
    </div>  
</div>
<input type="hidden" name="logoX" id="logoX" value="256.5">
<input type="hidden" name="logoY" id="logoY" value="390">
<input type="file" class="custom-file-input upload-file" id="uploadlogo" accept="image/*">
<input type="hidden" id="logofile" name="logofile" value="../assets/bayern/logo.svg">

