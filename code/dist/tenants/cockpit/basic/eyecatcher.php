<h3><i class="far fa-eye"></i> Störer</h3>
<div class="eyecatcher list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content">
        <div class="d-flex align-items-lg-center">
            <textarea name="pintext" id="pintext" placeholder="Störertext" value="" class="form-control"></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="form-range" name="eyecatchersize" id="eyecatchersize" min="50"
                    max="300" value="100" disabled>
                <small>groß</small>
            </div>
            <div>
                <span class="to-front" data-target="pin" title="Störer nach vorne">
                    <i class="fas fa-layer-group text-primary"></i>
                </span> 
            </div>
        </div>    
        <div>
            <input type="color" name="eyecatcherbackgroundcolor" id="eyecatcherbackgroundcolor" value="#000000">
        </div>
        <div class="mb-1 d-flex align-items-lg-center">
            <select class="form-control" name="eyecatcherfont" id="eyecatcherfont">
                <?php echo $fontOptionsInCockpit; ?>
            </select>
            <i class="fa fa-upload text-primary cursor-pointer ms-2 uploadfontclicker" title="Schrift hochladen"></i>
        </div>
    </div>
</div>

<input type="hidden" name="pinX" id="pinX">
<input type="hidden" name="pinY" id="pinY">