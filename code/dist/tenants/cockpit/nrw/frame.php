<h3 class=" showonly floating berlintext"><i class="fas fa-fan"></i> Rahmen</h3>
<div class="logo list-group-item list-group-item-action flex-column align-items-start showonly floating berlintext">           
    <div class="">

        <div class="d-flex">
            <label class="me-3">
                <input type="checkbox" class="form-check-input me-1" id="frame" name="frame" value="1" > Rahmen anzeigen
            </label>
            <input type="hidden" name="framecolor" id="framecolor" value="#b9ce1d">
            <span class="colorpicker ms-1"  id="framecolorpicker" data-colors="#b9ce1d,#33582d,#b7398e" data-action="frame.draw()" data-field="#framecolor" title="Farbe wechseln"></span>
        </div>

        <div class="d-flex justify-content-between">
            <div class="slider">
                <small>dünn</small>
                    <input type="range" class="form-range" name="framewidth" id="framewidth" min="1" max="100" value="50">
                <small>dick</small>
            </div>

        </div>
    </div>
    
</div>
<input type="hidden" name="logoX" id="logoX" value="380">
<input type="hidden" name="logoY" id="logoY" value="220">
