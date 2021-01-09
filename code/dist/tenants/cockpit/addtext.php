<h3 class="collapsed expertmode" data-toggle="collapse" data-target=".addtext"><i class="fa fa-asterisk"></i> Sternchentext</h3>
        <div class="addtext expertmode list-group-item list-group-item-action flex-column align-items-start collapse">
            <div class="mb-1 list-group-item-content">
                <div class="d-flex align-items-lg-center">
                    <textarea name="addtext" id="addtext" placeholder="Sternchentext" value="" class="form-control"></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="slider">
                        <small>klein</small>
                        <input type="range" class="custom-range" name="addtextsize" id="addtextsize" min="0"
                            max="50" value="20">
                        <small>groß</small>
                    </div>
                    <div>
                        <span class="to-front" data-target="addtext" title="Sternchentext nach vorne">
                            <i class="fas fa-layer-group text-primary"></i>
                        </span> 
                        <i class="fa fa-broom ml-1 text-primary cursor-pointer addtext-change-color ml-1" title="Farbe wechseln"></i>
                    </div>
                </div>    
            </div>
        </div>

        <input type="hidden" name="addtextX" id="addtextX">
        <input type="hidden" name="addtextY" id="addtextY">