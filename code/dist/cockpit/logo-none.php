<h3 class="d-none collapsed" data-bs-toggle="collapse" data-bs-target=".logo"><i class="fas fa-fan"></i> Logo</h3>
<div class="d-none logo collapse list-group-item list-group-item-action flex-column align-items-start">
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
            <optgroup label="Speziallogos">
                <option value="frauenrechte">Frauenrechte</option>
                <option value="regenbogen">Regenbogen</option>
                <option value="europa">Europa</option>
            </optgroup>
            <optgroup label="Kein Logo">
                <option value="void">kein Logo</option>
            </optgroup>
        </select>
            <i class="fa fa-upload text-cockpit cursor-pointer uploadlogoclicker ms-2" title="Eigenes Logo hochladen"></i>
            <i class="fa fa-trash text-cockpit cursor-pointer overlay-opener nav-lin ms-2" data-bs-target="preferences" title="Logos löschen"></i>

    </div>
    <div class="">
        <input type="text" placeholder="Text im blauen Balken: KV oder OV" name="logochapter" id="logochapter" value=""
                class="form-control form-control-sm">
    </div>
    <div class="d-flex justify-content-between">
        <div class="slider">
            <small>klein</small>
                <input type="range" class="form-range" name="logosize" id="logosize" min="1" max="100" value="10">
            <small>groß</small>
        </div>
        <div>
            <span class="to-front" data-bs-target="logo" title="Logo nach vorne">
                <i class="fas fa-layer-group text-cockpit"></i>
            </span> 
        </div>
    </div>
</div>
<input type="file" class="custom-file-input upload-file" id="uploadlogo" accept="image/*">