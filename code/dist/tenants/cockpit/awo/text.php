

        <h3><i class="fas fa-text-width"></i> Text</h3>
        <div class="text list-group-item list-group-item-action flex-column align-items-start">
            
            <div class="d-none justify-content-around">
                <label class="me-3">Layout:</label>
                 <label class="">
                    <input type="radio" class="form-check-input layout me-1" name="layout" value="floating" checked>Schwebend
                 </label>
                 <label class="">
                    <input type="radio" class="form-check-input layout me-1" name="layout" value="area" >Fläche
                 </label>
                 <label class="">
                    <input type="radio" id="layout-cite" class="form-check-input layout me-1" name="layout" value="floating">Zitat
                 </label>
            </div>

            <div class="list-group-item-content">
                    
               
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control">Bildung ist mehr Wert.</textarea>
                </div>
                <div class="cockpit-row ">
                    <div class="me-4">Farbe:</div>
                    <input type="color" name="textcolor" id="textcolor" value="#FFFFFF" title="Farbe wählen">
                </div>
                <div class="cockpit-row">
                    <div class="me-4">Schriftart:</div>
                    <select class="form-select" name="textfont" id="textfont">
                        <option value="Paralucent Condensed">Paralucent Condensed</a>
                        <option value="SaunaPro">Sauna Pro</a>
                    </select>
                </div>
               

                <div class="cockpit-row">
                    <div class="me-4">Größe:</div>
                    <div class="d-flex justify-content-between">
                        <div class="slider">
                            <span>klein</span>
                            <input type="range" class="form-range" name="textsize" id="textsize" min="1" max="100">
                            <span>groß</span>
                        </div>

                    </div>
                </div>

                <div class="cockpit-row">
                    <div class="me-4">Position:</div>
                    <div class="d-flex justify-content-between">  
                        <div class="d-flex">
                            <div class="me-3">
                                <span class="cursor-pointer ms-3 text-primary align-center-text showonly floating">
                                    <i class="fab fa-centercode" title="Text in Bildmitte"></i></span>
                            </div> 
                            <div>
                                <span class="to-front" data-target="text" title="Text nach vorne">
                                    <i class="fas fa-layer-group text-primary"></i>
                                </span> 
                            </div>
                        </div>
                    </div> 
                    </div>

                <div class="d-none preferences-text">
                    <div class="showonly floating">  
                         <label class="me-3">
                            <input type="checkbox" class="form-check-input" name="textShadow" id="textShadow">
                            Schatten hinter Text
                        </label>
                    </div>
                </div>

                 <div class="d-none">
                    <div class="me-2">Sonderzeichen:</div>
                    <ul class="text-symbols">
                        <li class="text-symbol" data-symbol="CO₂" title="mit tiefergesteller 2" role="button">CO₂</li>   
                        <li class="text-symbol" data-symbol="•" title="Aufzählungszeichen" role="button">•</li>  
                        <li class="text-symbol" data-symbol="„" title="Anführungszeichen unten" role="button">„</li>  
                        <li class="text-symbol" data-symbol="“" title="Anführungszeichen oben" role="button">“</li>                               
                    </ul>
                </div>
            </div>
        </div>
        <input type="hidden" name="iconfile" id="iconfile">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="textColor" id="textColor" value="0">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">