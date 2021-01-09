<h3 class="collapsed" data-toggle="collapse" data-target=".eyecatcher"><i class="far fa-eye"></i> Störer</h3>
        <div class="eyecatcher list-group-item list-group-item-action flex-column align-items-start collapse">
            <div class="mb-1 list-group-item-content">
                <div class="d-flex align-items-lg-center">
                    <textarea name="pintext" id="pintext" placeholder="Störertext. Maximal 2 Zeilen." value="" class="form-control height1line"></textarea>
                </div>
                <div class="d-none align-items-lg-center">
                    <textarea name="pinurl" id="pinurl" placeholder="URL" value="" class="form-control height1line"></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="slider">
                        <small>klein</small>
                        <input type="range" class="custom-range" name="eyecatchersize" id="eyecatchersize" min="50"
                            max="300" value="100" disabled>
                        <small>groß</small>
                    </div>
                    <div>
                        <i class="fa fa-broom ml-1 text-primary cursor-pointer pin-change-color ml-1" title="Hintergrundfarbe wechseln"></i>

                        <span class="to-front" data-target="pin" title="Störer nach vorne">
                            <i class="fas fa-layer-group text-primary"></i>
                        </span> 
                    </div>
                </div>    
            </div>
        </div>
        <input type="hidden" name="pinX" id="pinX">
<input type="hidden" name="pinY" id="pinY">
<input type="hidden" name="pinColor" id="pinColor" value="2">
