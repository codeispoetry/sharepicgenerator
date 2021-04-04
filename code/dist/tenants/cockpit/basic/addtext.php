<h3 class="collapsed expertmode" data-toggle="collapse" data-target=".addtextbasic"><i class="fa fa-asterisk"></i> Sternchentext</h3>
<div class="addtextbasic expertmode list-group-item list-group-item-action flex-column align-items-start collapse">
    <div class="mb-1 list-group-item-content">
        <div class="d-flex align-items-lg-center">
            <textarea name="addtextbasic" id="addtextbasic" placeholder="Sternchentext" value="" class="form-control"></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="custom-range" name="addtextbasicsize" id="addtextbasicsize" min="0"
                    max="50" value="20">
                <small>groß</small>
            </div>
            <div>
                <span class="to-front" data-target="addtextbasic" title="Sternchentext nach vorne">
                    <i class="fas fa-layer-group text-primary"></i>
                </span> 
            </div>
        </div>  

        <div>
            <input type="color" name="addtextbasicColor" id="addtextbasicColor" value="#000">
        </div> 
        <div class="mb-1 d-flex align-items-lg-center">
            <select class="form-control" name="addtextbasicfont" id="addtextbasicfont">
                <?php echo $fontOptionsInCockpit; ?>
            </select>
            <i class="fa fa-upload text-primary cursor-pointer ml-2 uploadfontclicker" title="Schrift hochladen"></i>
        </div> 
    </div>
</div>

<input type="hidden" name="addtextbasicX" id="addtextbasicX">
<input type="hidden" name="addtextbasicY" id="addtextbasicY">