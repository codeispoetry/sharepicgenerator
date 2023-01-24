<h3><i class="fas fa-text-width"></i> Text</h3>
        <div class="text  list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-none justify-content-between form-check form-check-inline">
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

            <div class="ms-1"> 
                <span class="textanchor" data-payload="left" title="Text linksbündig">
                    <i class="fa fa-align-left text-cockpit"></i>
                </span>
                <span class="textanchor" data-payload="middle" title="Text zentrieren">
                    <i class="fa fa-align-center text-cockpit"></i>
                </span>
                
                <span class="to-front" data-target="text" title="Text nach vorne">
                    <i class="fas fa-layer-group text-cockpit"></i>
                </span> 

                <span class="colorpicker" data-colors="#ffffff,#000000,#009571,#46962b,#E6007E,#FEEE00" data-action="nolines.draw()" data-field="#textprimarycolor" title="Hauptfarbe wechseln"></span> 
                <span class="colorpicker" data-colors="#ffffff,#000000,#009571,#46962b,#E6007E,#FEEE00" data-action="nolines.draw()  " data-field="#textsecondarycolor" title="Akzentfarbe wechseln"></span> 

            </div>

            <div class="list-group-item-content">
                <div class="d-none">
                    <input type="text" placeholder="Text über der Linie" name="textbefore" id="textbefore" value=""
                           class="form-control showonly lines nolines">
                </div>
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control">Wachsen wir
über uns hinaus.</textarea>
                </div>
                <div class="d-flex align-items-lg-center">
                    <textarea placeholder="Text unter der Linie" name="textafter" id="textafter" value="" class="form-control showonly lines nolines quote"></textarea>
                </div>

                <div class="mb-1 mt-2">
                    <div class="d-flex justify-content-between mt-3">
                        <small class="showonly lines nolines quote">Text in eckigen Klammern [ ] wird hervorgehoben</small>
                        <small class="cursor-pointer ms-3 text-cockpit aligncenter showonly lines nolines quote">
                            <i class="fa fa-align-center"></i>
                            in Bildmitte</small>
                    </div>
                </div>


                <div class="mb-1 mt-2">
                    <div class="d-flex justify-content-between">
                        <div class="slider">
                            <small>klein</small>
                            <input type="range" class="form-range" name="textsize" id="textsize" min="1" max="100">
                            <small>groß</small>
                        </div>
                    </div> 
                    </div>

                <div class="preferences-text">
                    <div class="d-flex justify-content-between">
                        <div class="d-none">
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
                            <span class="colorpicker ms-1" data-colors="#ffffff,#000000,#009571,#46962b,#E6007E,#FEEE00" data-action="nolines.draw()" data-field="#colorbehindtext" title="Farbe wechseln"></span> 
                            <input type="hidden" name="colorbehindtext" id="colorbehindtext" value="#000">
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
        <input type="hidden" name="textanchor" id="textanchor" value="middle">
        <input type="hidden" name="textprimarycolor" id="textprimarycolor" value="white">
        <input type="hidden" name="textsecondarycolor" id="textsecondarycolor" value="white">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">