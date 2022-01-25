<h3><i class="far fa-eye"></i> Störer</h3>
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
        <div class="d-flex align-items-lg-center">
            <textarea name="pintext" id="pintext" placeholder="Dein Text" class="form-control" data-maxlines="3"></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="form-range" name="eyecatchersize" id="eyecatchersize" min="50"
                    max="300" value="100">
                <small>groß</small>
            </div>
            <div>
                <span class="cursor-pointer ms-3 text-primary align-center-eyecatcher">
                   <i class="fab fa-centercode" title="Störer in Bildmitte"></i></span>
                <span class="to-front" data-target="pin" title="Störer nach vorne">
                    <i class="fas fa-layer-group text-primary"></i>
                </span>
                <input type="hidden" name="pincolor" id="pincolor" value="#b7398e">
                <span class="colorpicker ms-1"  id="pincolorpicker" data-colors="#b9ce1d,#33582d,#b7398e" data-action="pin.draw()" data-field="#pincolor" title="Farbe wechseln"></span>
            </div>
        </div>    
    </div>
</div>

<input type="hidden" name="pinX" id="pinX">
<input type="hidden" name="pinY" id="pinY">