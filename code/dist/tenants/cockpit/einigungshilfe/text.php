

        <h3 class=""><i class="fas fa-text-width"></i> Text</h3>
        <div class="text list-group-item list-group-item-action flex-column align-items-start">
        
            <div class="d-none justify-content-between form-check form-check-inline">
                 <label class="d-none">
                    <input type="radio" class="form-check-input layout" name="layout" value="basic" checked>Standard
                 </label>

               
            </div>

            <div class="mb-1 d-flex align-items-lg-center dd-none">
                <input type="hidden" id="textfont" value="SaunaPro">
            </div>


            <div>

                <i class="fas fa-align-left text-primary click-setter d-none" data-action="basic.draw()" data-field="#textanchor" data-value="left" title="Text linksbündig"></i>
                <i class="fas fa-align-center text-primary click-setter d-none" data-action="basic.draw()" data-field="#textanchor" data-value="middle" title="Text mittig"></i>

                <label>
                    <input type="checkbox" name="textshadow" id="textshadow">
                    Textschatten
                </label>

                <input type="hidden" name="textanchor" id="textanchor" value="left">
                <input type="color" name="textcolor" id="textcolor" value="#ffffff">
                <span class="colorpicker ms-1" data-colors="#ffffff,#000000,#2d81c9" data-action="basic.draw()" data-field="#textcolor" title="Farbe wechseln"></span> 
            </div>

            <div class="list-group-item-content">
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control">Werde
kreativ</textarea>
                </div>
                <div class="mb-1 mt-2">
                    <div class="d-flex justify-content-between mt-3">
                        <small class="showonly lines nolines quote">Text in eckigen Klammern [ ] wird hervorgehoben</small>
                        <small class="cursor-pointer ms-3 text-primary aligncenter showonly lines nolines quote">
                            <i class="fa fa-align-center"></i>
                            mittig ausrichten</small>
                    </div>
                </div>


                <div class="mb-1 mt-2">
                    <div class="d-flex justify-content-between">
                        <div class="slider">
                            <small>klein</small>
                            <input type="range" class="form-range" name="textsize" id="textsize" min="1" max="100">
                            <small>groß</small>
                        </div>
                        <div>
                            <span class="to-front" data-target="text" title="Text nach vorne">
                                <i class="fas fa-layer-group text-primary"></i>
                            </span> 
                        </div>
                    </div> 
                    </div>    
            </div>
            
        </div>
        <input type="hidden" name="iconfile" id="iconfile">
        <input type="hidden" placeholder="Text unter der Linie" name="textafter" id="textafter" value="<?php echo getSaying('lower'); ?>" class="form-control showonly lines nolines quote">
        <input type="hidden" placeholder="Text über der Linie" name="textbefore" id="textbefore" value="" class="form-control showonly lines nolines">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="textColor" id="textColor" value="1">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadfont">