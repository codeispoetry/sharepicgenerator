<h3 class="collapsed KILLexpertmode" data-toggle="collapse" data-target=".logo"><i class="fas fa-fan"></i> Logo</h3>
        <div class="logo KILLexpertmode collapse list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 d-flex align-items-lg-center">
                <select class="form-control" name="logoselect" id="logoselect">  
                    <optgroup label="BW">
                        <option value="fanleft">Fächer links</option>
                        <option value="fancenter">Fächer mitte</option>
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
                 <i class="fa fa-upload text-primary cursor-pointer uploadlogoclicker ml-2" title="Eigenes Logo hochladen"></i>

            </div>
            <div class="d-flex justify-content-between">
                <div class="slider d-none">
                    <small>klein</small>
                        <input type="range" class="custom-range" name="logosize" id="logosize" min="1" max="100" value="10">
                    <small>groß</small>
                </div>
                <div class="slider fanonly">
                    <small>Fächer:&nbsp;links</small>
                        <input type="range" class="custom-range" name="fanposition" id="fanposition" min="-100" max="100" value="0">
                    <small>rechts</small>
                </div>

                <div class="d-none">
                    <span class="to-front" data-target="logo" title="Logo nach vorne">
                        <i class="fas fa-layer-group text-primary"></i>
                    </span> 
                </div>
            </div>
        </div>