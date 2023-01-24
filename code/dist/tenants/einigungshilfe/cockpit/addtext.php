<h3><i class="fa fa-asterisk"></i> Sternchentext</h3>
<div class="addtextbasic list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content">
        <div class="d-flex align-items-lg-center">
            <textarea name="addtextbasic" id="addtextbasic" placeholder="Sternchentext" value="" class="form-control"></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="form-range" name="addtextbasicsize" id="addtextbasicsize" min="0"
                    max="50" value="20">
                <small>groß</small>
            </div>
            <div>
                <span class="to-front" data-target="addtextbasic" title="Sternchentext nach vorne">
                    <i class="fas fa-layer-group text-cockpit"></i>
                </span> 
            </div>
        </div>  

        <div>
            <input type="color" name="addtextbasicColor" id="addtextbasicColor" value="#000">
            <span class="colorpicker ms-1" data-colors="#ffffff,#000000,#5488C7,#CDDCF4,#285F96,#FFB100" data-action="addtextbasic.draw()" data-field="#addtextbasicColor" title="Farbe wechseln"></span>

        </div> 
        <div class="mb-1 d-flex align-items-lg-center">
            <select class="form-control" name="addtextbasicfont" id="addtextbasicfont">
                <?php echo $fontOptionsInCockpit; ?>
            </select>
            <i class="fa fa-upload text-cockpit cursor-pointer ms-2 uploadfontclicker" title="Schrift hochladen"></i>
        </div> 
    </div>
</div>

<input type="hidden" name="addtextbasicX" id="addtextbasicX">
<input type="hidden" name="addtextbasicY" id="addtextbasicY">