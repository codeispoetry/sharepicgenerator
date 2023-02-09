<h3><i class="fa fa-asterisk"></i> Sternchentext</h3>
<div class="addtext list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content">
        <div class="d-flex align-items-lg-center">
            <textarea name="addtext" id="addtext" placeholder="Sternchentext" value="" class="form-control"></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="form-range" name="addtextsize" id="addtextsize" min="0"
                    max="50" value="20">
                <small>groß</small>
            </div>
            <div>
                <input type="hidden" name="addtextColor" id="addtextColor" value="<?php getColorAtIndex(1); ?>">
                <span class="colorpicker ms-1" data-colors="<?php getColorAtIndex(); ?>" data-action="addtext.draw()" data-field="#addtextColor" title="Farbe wechseln"></span> 
            </div>
        </div>    
    </div>
</div>

<input type="hidden" name="addtextX" id="addtextX" value="10">
<input type="hidden" name="addtextY" id="addtextY" value="10">
<input type="hidden" name="addtextFont" id="addtextFont" value="PTSans">
