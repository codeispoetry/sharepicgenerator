

        <h3>Text</h3>
        <div class="text list-group-item list-group-item-action flex-column align-items-start">
            
            <div class="list-group-item-content">
                <div class="d-flex justify-content-end">
                    <i class="fa fa-align-left text-align me-2" data-align="left" title="linksbündig"></i>
                    <i class="fa fa-align-center text-align me-2" data-align="middle" title="zentrieren"></i>
                    <i class="fa fa-align-right text-align" data-align="end" title="rechtsbündig"></i>
                </div>
                <div class="d-flex align-items-lg-center">
                    <input type="text" placeholder="Text darüber" name="textbefore" id="textbefore" value="" class="form-control">
                </div>
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control">Bereit, weil Ihr es seid.</textarea>
                </div>
                <div class="d-flex align-items-lg-center">
                    <textarea placeholder="Text unter der Linie" name="textafter" id="textafter" value="" class="form-control h-1em"></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="">
                        <input type="text" placeholder="Claim" name="claimtext" id="claimtext" value="" class="form-control">
                    </div>    
                    <div>
                        <input type="hidden" name="claimcolor" id="claimcolor" value="#ffe100">
                        <span class="colorpicker ms-1"  id="claimcolorpicker" data-colors="#ffe100,#FF495D" data-action="floating.draw()" data-field="#claimcolor" title="Farbe wechseln"></span>
                    </div>    
                </div>

                <div class="mb-1 mt-2">
                    <div class="d-flex justify-content-between">
                        <div class="slider">
                            <small>klein</small>
                            <input type="range" class="form-range" name="textsize" id="textsize" min="1" max="100">
                            <small>groß</small>
                        </div>
                        <div class="d-flex">
                            <div class="me-3">
                                <span class="cursor-pointer ms-3 text-cockpit align-center-text">
                                    <i class="fab fa-centercode" title="Text in Bildmitte"></i></span>
                            </div> 
                            <div>
                                <span class="to-front" data-target="floating" title="Text nach vorne">
                                    <i class="fas fa-layer-group text-cockpit"></i>
                                </span> 
                            </div>
                        </div>
                    </div> 
                    </div>

                <div class="preferences-text">
                    <div class="">  
                         <label class="me-3">
                            <input type="checkbox" class="form-check-input" name="textShadow" id="textShadow">
                            Schatten hinter Text
                        </label>
                    </div>
                </div>

                 <div class="d-flex">
                    <div class="me-2">Sonderzeichen:</div>
                    <ul class="text-symbols">
                        <li class="text-symbol" data-symbol="CO₂" title="mit tiefergesteller 2" role="button">CO₂</li>   
                        <li class="text-symbol" data-symbol="•" title="Aufzählungszeichen" role="button">•</li>  
                        <li class="text-symbol" data-symbol="„" title="Anführungszeichen unten" role="button">„</li>  
                        <li class="text-symbol" data-symbol="“" title="Anführungszeichen oben" role="button">“</li>                               
                    </ul>
                </div>
                 <div class="d-flex">
                   <span class="btn btn-lachs" id="ask-ai">Textvorschlag erhalten</span> 
                </div>
            </div>
        </div>
        <input type="hidden" name="iconfile" id="iconfile">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="textColor" id="textColor" value="0">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">