

        <h3 class="" data-toggle="collapse" data-target=".text"><i class="fas fa-text-width"></i> Text</h3>
        <div class="text collapse show list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex justify-content-between form-check form-check-inline">
                <label class="">
                    <input type="radio" class="form-check-input layout" name="layout" value="lines">Mit Linien
                 </label>
                 <label class="">
                    <input type="radio" class="form-check-input layout" name="layout" value="nolines" checked>Ohne Linien
                 </label>
                 <label class="">
                    <input type="radio" class="form-check-input layout" name="layout" value="invers">Invers
                 </label>
                 <label class="">
                    <input type="radio" class="form-check-input layout" name="layout" value="quote">Zitat
                 </label>
            </div>

            <div class="list-group-item-content">
                <div class="">
                    <input type="text" placeholder="Text über der Linie" name="textbefore" id="textbefore" value="Sharepicgenerator.de"
                           class="form-control showonly lines nolines">
                </div>
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control">Es beginnt
#mitdir.</textarea>
                </div>
                <div class="d-flex align-items-lg-center">
                    <input type="text" placeholder="Text unter der Linie" name="textafter" id="textafter" value="Werde kreativ!" class="form-control showonly lines nolines quote">
                </div>

                <div class="mb-1 mt-2">
                    <div class="d-flex justify-content-between mt-3">
                        <small class="showonly lines nolines quote">Text in eckigen Klammern [ ] wird gelb</small>
                        <small class="cursor-pointer ml-3 text-primary aligncenter showonly lines nolines quote">
                            <i class="fa fa-align-center"></i>
                            mittig ausrichten</small>
                    </div>
                </div>


                <div class="mb-1 mt-2">
                    <div class="d-flex justify-content-between">
                        <div class="slider">
                            <small>klein</small>
                            <input type="range" class="custom-range" name="textsize" id="textsize" min="1" max="100">
                            <small>groß</small>
                        </div>
                        <div>
                            <span class="to-front" data-target="text" title="Text nach vorne">
                                <i class="fas fa-layer-group text-primary"></i>
                            </span> 
                        </div>
                    </div> 
                    </div>

                <div class="preferences-text">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <label class="showonly lines">
                                <input type="checkbox" name="textsamesize" id="textsamesize">
                                Zeilen gleich lang
                            </label>
                            <label class="showonly lines">
                                <input type="checkbox" name="greenbehindtext" id="greenbehindtext">
                                Grün hinter Text
                            </label>
                        </div>
                        <div>
                            <label class="showonly lines nolines quote">
                                <input type="checkbox" name="graybehindtext" id="graybehindtext">
                                Farbe hinter Text
                            </label>
                            <span class="colorpicker ml-1" data-colors="#ffffff,#000000,#009571,#46962b,#E6007E,#FEEE00" data-action="nolines.draw()" data-field="#colorbehindtext" title="Farbe wechseln"></span> 
                            <input type="hidden" name="colorbehindtext" id="colorbehindtext" value="#000">
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