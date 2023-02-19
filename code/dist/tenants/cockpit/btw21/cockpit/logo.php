<h3 class="">Logo</h3>
<div class="logo list-group-item list-group-item-action flex-column align-items-start showonly floating berlintext">
    <nav class="navbar-expand-lg">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="menu-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    Ausrichtung
                </a>
                <ul class="dropdown-menu">
                    <li class="align-logo" data-place="topright"><span>rechts oben</span></li>
                    <li class="to-front" data-target="defaultlogo"><span>in Vordergrund</span></li>
                </ul>
            </li>
        </ul>   
    </nav>
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
<input type="hidden" name="logoX" id="logoX" value="256.5">
<input type="hidden" name="logoY" id="logoY" value="390">
<input type="file" class="custom-file-input upload-file" id="uploadlogo" accept="image/*">
<input type="hidden" id="logofile" name="logofile">

