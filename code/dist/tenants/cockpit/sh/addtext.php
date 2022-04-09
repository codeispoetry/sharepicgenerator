<h3><i class="fa fa-asterisk"></i> Sternchentext</h3>
<div class="addtext list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content">
        <div class="d-flex align-items-lg-center">
            <textarea name="addtextSH" id="addtextSH" placeholder="Zusatzzeile" value="" class="form-control"></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="form-range" name="addtextsizeSH" id="addtextsizeSH" min="0"
                    max="50" value="20">
                <small>groß</small>
            </div>
            <div>
                <span class="to-front" data-target="addtext" title="Sternchentext nach vorne">
                    <i class="fas fa-layer-group text-primary"></i>
                </span> 
                <input type="hidden" name="addtextColor" id="addtextColor" value="#000000">
                <span class="colorpicker ms-1" data-colors="#FFFFFF,#000000,#B7388D,#E4C9DD,#155929,#B9CE1E" data-action="addtext.draw()" data-field="#addtextColor" title="Farbe wechseln"></span> 
            </div>
        </div>    
    </div>
</div>

<input type="hidden" name="addtextX" id="addtextX">
<input type="hidden" name="addtextY" id="addtextY">