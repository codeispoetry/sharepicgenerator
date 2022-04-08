<h3><i class="far fa-eye"></i> Absender*in</h3>
<div class="eyecatcher list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content">
        
        <div class="d-flex align-items-lg-center">
            <textarea name="pintext" id="pintext" placeholder="Absender*in" class="form-control" data-maxlines="5"></textarea>
        </div>
        <div class="d-flex">

            <div class="cockpit-row">
					<div class="me-4">Größe:</div>

                    <div class="slider">
                        <span>klein</span>
                        <input type="range" class="form-range" name="eyecatchersize" id="eyecatchersize" min="50"
                            max="300" value="100">
                        <span>groß</span>
                    </div>
            </div>
        </div>
        <div class="d-flex">
            <div class="cockpit-row">
					<div class="me-4">Position:</div>
                    <div class="d-flex">
                        <span class="cursor-pointer me-3 text-primary align-center-eyecatcher">
                        <i class="fab fa-centercode" title="Störer in Bildmitte"></i></span>
                        <span class="to-front" data-target="pin" title="Störer nach vorne">
                            <i class="fas fa-layer-group text-primary"></i>
                        </span> 
                    </div>
            </div>
        </div>    
    </div>
</div>

<input type="hidden" name="pinX" id="pinX">
<input type="hidden" name="pinY" id="pinY">