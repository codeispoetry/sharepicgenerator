

        <h3><i class="fas fa-text-width"></i> Text</h3>
        <div class="text list-group-item list-group-item-action flex-column align-items-start">
            
            <div class="d-none">
                 <label class="me-3">
                    <input type="radio" class="form-check-input layout me-1" name="layout" value="floating" checked>Schwebend
                 </label>
                 <label class="">
                    <input type="radio" class="form-check-input layout me-1" name="layout" value="area" >Grüne Fläche
                 </label>
            </div>

            <div class="d-flex">
                <label class="me-3">
                    <input type="checkbox" class="form-check-input me-1" id="frame" name="frame" value="1" >mit Rahmen
                </label>
                <input type="hidden" name="framecolor" id="framecolor" value="#b9ce1d">
                <span class="colorpicker ms-1"  id="framecolorpicker" data-colors="#b9ce1d,#33582d,#b7398e" data-action="frame.draw()" data-field="#framecolor" title="Farbe wechseln"></span>
            </div>

            <div class="list-group-item-content">
                <div class="d-flex justify-content-end">
                    <label class="d-flex">
                        <i class="fas fa-cube me-2 toggle-text-shadow showonly floating d-none" title="Text mit Schatten hinterlegen"></i>  
                        <input type="checkbox" id="floatingshadow" name="floatingshadow" class="d-none">
                    </label>
                    <i class="fa fa-text-height toggle-line-height me-2" title="Zeilenabstand ändern"></i>
                    <i class="fa fa-align-left text-align me-2 showonly floating" data-align="left" title="linksbündig"></i>
                    <i class="fa fa-align-right text-align showonly floating" data-align="end" title="rechtsbündig"></i>
                </div>
                <div class="d-flex align-items-lg-center">
                    <input type="text" placeholder="Text darüber" name="textbefore" id="textbefore" value="" class="d-none form-control showonly area floating">
                </div>
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control"><?php echo getSaying('main'); ?></textarea>
                </div>
                <div class="d-flex align-items-lg-center">
                    <input type="text" placeholder="Text darunter" name="textafter" id="textafter" value="" class="d-none form-control showonly area floating">
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

                <div class="preferences-text">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <label class="">
                                <input type="checkbox" class="form-check-input" name="showclaim" id="showclaim">
                                Zeige Claim
                            </label>
                        </div>
            
                       
                    </div>
                </div>
            </div>
            <div class="preferences-text showonly lines">
                <div class="d-flex justify-content-between mt-3">
                    <span class="text-primary cursor-pointer uploadiconclicker">
                        <i class="fa fa-upload"></i> Icon hochladen
                    </span>

                    <span class="text-primary cursor-pointer overlay-opener" data-target="iconoverlay">
                        <i class="fas fa-search"></i> Icon suchen
                    </span>
                </div>
                <div class="mb-1 list-group-item-content d-none iconsizeselectwrapper">
                    <select class="form-control" name="iconsize" id="iconsize">
                        <option value="1">Icon: 1 Zeile hoch</option>
                        <option value="2">Icon: 2 Zeilen hoch</option>
                        <option value="3">Icon: 3 Zeilen hoch</option>
                        <option value="0">Icon entfernen</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="hidden" name="iconfile" id="iconfile">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="textColor" id="textColor" value="0">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">