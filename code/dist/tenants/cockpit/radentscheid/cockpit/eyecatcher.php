<h3>Störer</h3>
<div class="eyecatcher list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content">
        <div class="d-none">
            <select class="form-select" name="eyecatchertemplate" id="eyecatchertemplate">
                <option value="">Vorlage wählen</option>
                <option value="custom">Text selbst eingeben</option>
                <optgroup label="Vorlagen">
                    <option value="btw21/zweitstimme.svg">Zweitstimme Grün!</option>
                    <option value="btw21/briefwahl.svg">Briefwahl jetzt!</option>
                </optgroup>
            </select>
            oder
        </div>
        <div class="d-flex">
            <textarea name="pintext" id="pintext" placeholder="Dein Text" class="form-control" data-maxlines="3"></textarea>
            <div>
                <input type="hidden" name="pincolor" id="pincolor" value="<?php getColorAtIndex(1); ?>">
                <span class="colorpicker ms-1"  id="pincolorpicker" data-colors="<?php getColorAtIndex(); ?>" data-action="pin.draw()" data-field="#pincolor" title="Farbe wechseln"></span>
            </div>   
        </div>
        <div class="d-flex">
            <div class="slider">
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