

        <h3>Text</h3>
        <div class="text list-group-item list-group-item-action flex-column align-items-start">
            
            <div class="d-block list-group-item-content">
               
                <div class="d-none align-items-lg-center">
                    <input type="text" placeholder="Text darüber" name="textbefore" id="textbefore" value="" class="form-control">
                </div>
                <div class="d-flex">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control">Sicher
Radeln
Jetzt!</textarea>

                    <input type="hidden" name="textcolor" id="textcolor" value="<?php getColorAtIndex(2); ?>">
                    <span 
                        class="colorpicker ms-1"  
                        id="textcolorpicker" 
                        data-colors="<?php getColorAtIndex(); ?>" 
                        data-action="floating.draw()" 
                        data-field="#textcolor" 
                        title="Farbe wechseln"></span> 
                </div>
                <div class="d-none align-items-lg-center">
                    <textarea placeholder="Text unter der Linie" name="textafter" id="textafter" value="" class="form-control h-1em"></textarea>
                </div>
                <div class="d-none justify-content-between">
                    <div class="">
                        <input type="text" placeholder="Claim" name="claimtext" id="claimtext" value="" class="form-control">
                    </div>    
                    <div>
                        <input type="hidden" name="claimcolor" id="claimcolor" value="#e2ba00">
                        <span class="colorpicker ms-1"  id="claimcolorpicker" data-colors="#1a1a18,#008fcf,#e2ba00,#ffffff" data-action="floating.draw()" data-field="#claimcolor" title="Farbe wechseln"></span>
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
                
            </div>
        </div>
        <input type="hidden" name="iconfile" id="iconfile">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="textColor" id="textColor" value="0">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">