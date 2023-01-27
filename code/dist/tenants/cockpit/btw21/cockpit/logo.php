<h3 class="">Logo</h3>
<div class="logo list-group-item list-group-item-action flex-column align-items-start showonly floating berlintext">
    
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
        <div>
            <span class="cursor-pointer text-cockpit align-center-logo">
                <i class="fab fa-centercode" title="Logo in Bildmitte"></i>
            </span>
            <span class="to-front" data-target="logo" title="Logo nach vorne">
                <i class="fas fa-layer-group text-cockpit"></i>
            </span> 
        </div>
    </div>
    
</div>
<input type="hidden" name="logoX" id="logoX" value="256.5">
<input type="hidden" name="logoY" id="logoY" value="390">
