<h3><i class="far fa-eye"></i> Ihre Einrichtung</h3>
<div class="eyecatcher list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content">
        
        <div class="d-flex align-items-lg-center">
            <textarea name="pintext" id="pintext" placeholder="Einrichtung" class="form-control" data-maxlines="3"></textarea>
        </div>
        <div class="d-flex justify-content-end">
            <div class="slider d-none">
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
            </div>
        </div>    
    </div>
</div>

<input type="hidden" name="pinX" id="pinX">
<input type="hidden" name="pinY" id="pinY">