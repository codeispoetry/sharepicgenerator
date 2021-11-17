<h3 ><i class="fas fa-fan"></i> Logo</h3>
        <div class="logo   list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 d-flex align-items-lg-center">
                <select class="form-control" name="logoselect" id="logoselect">             
                    <optgroup label="Fächer">
                        <option value="fancenter">Fächer mittig</option>
                        <option value="fanleft">Fächer links</option>
                        <option value="fanright">Fächer rechts</option>
                    </optgroup>
                   
                    <optgroup label="Sonnenblume">
                        <option value="sonnenblume">Sonnenblume</option>
                        <option value="sonnenblume-weiss">weiße Sonnenblume</option>
                    </optgroup>
                    <optgroup label="Kein Logo">
                        <option value="void">kein Logo</option>
                    </optgroup>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <div class="slider d-none">
                    <small>klein</small>
                        <input type="range" class="form-range" name="logosize" id="logosize" min="1" max="100" value="10">
                    <small>groß</small>
                </div>
            
                <div class="d-none">
                    <span class="to-front" data-target="logo" title="Logo nach vorne">
                        <i class="fas fa-layer-group text-primary"></i>
                    </span> 
                </div>
            </div>
        </div>