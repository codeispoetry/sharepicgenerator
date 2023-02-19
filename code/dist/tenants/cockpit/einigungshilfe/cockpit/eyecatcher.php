<h3>Störer</h3>
<div class="eyecatcher list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content">
        <div class="d-flex">
            <textarea name="pintext" id="pintext" placeholder="Dein Text" class="form-control"></textarea>
            
            <div style="white-space:nowrap">
                <input type="hidden" name="pincolor" id="pincolor" value="<?php getColorAtIndex(1); ?>">
                <span class="colorpicker ms-1"  id="pincolorpicker" data-colors="<?php getColorAtIndex(); ?>" data-action="pin.draw()" data-field="#pincolor" title="VordergrundFarbe wechseln"></span>
                Schrift<br>
                <input type="hidden" name="pinbgcolor" id="pinbgcolor" value="<?php getColorAtIndex(2); ?>">
                <span class="colorpicker ms-1"  id="pinbgcolorpicker" data-colors="<?php getColorAtIndex(); ?>" data-action="pin.draw()" data-field="#pinbgcolor" title="Hintergrundfarbe wechseln"></span>
                Hintergrund
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <div class="slider advancedmode d-none">
                <small>klein</small>
                <input type="range" class="form-range" name="eyecatchersize" id="eyecatchersize" min="50"
                    max="300" value="100">
                <small>groß</small>
            </div>
        </div>    
    </div>
</div>

<input type="hidden" name="pinX" id="pinX">
<input type="hidden" name="pinY" id="pinY">
<input type="hidden" name="pinFont" id="pinFont" value="<?php echo getFont();?>">
