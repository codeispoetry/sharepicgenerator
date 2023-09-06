<h3><i class="fa fa-asterisk"></i> Name</h3>
<div class="addtextnds list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content">
        <div class="d-flex align-items-lg-center">
            <input name="addtext" id="addtext" placeholder="Vor- und Nachname" value="" class="form-control">
        </div>
        <div class="d-flex justify-content-between">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="form-range" name="addtextsize" id="addtextsize" min="0"
                    max="50" value="20">
                <small>groß</small>
            </div>
            <div>
                <span class="to-front" data-target="addtext" title="Fließtext nach vorne">
                    <i class="fas fa-layer-group text-cockpit"></i>
                </span> 
                <input type="hidden" name="addtextColor" id="addtextColor" value="#e6e3bf">
                <span class="colorpicker ms-1" data-colors="#e6e3bf,#00594e,#ffe100,#f1912e" data-action="addtext.draw()" data-field="#addtextColor" title="Farbe wechseln"></span> 
            </div>
        </div>    
    </div>
</div>

<input type="hidden" name="addtextX" id="addtextX">
<input type="hidden" name="addtextY" id="addtextY">
<input type="hidden" name="addtextFont" id="addtextFont" value="BereitBold">
