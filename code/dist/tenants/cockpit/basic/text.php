

        <h3 class="" data-toggle="collapse" data-target=".text"><i class="fas fa-text-width"></i> Text</h3>
        <div class="text collapse show list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex justify-content-between form-check form-check-inline">
                 <label class="">
                    <input type="radio" class="form-check-input layout" name="layout" value="basic" checked>Standard
                 </label>
            </div>

            <div class="list-group-item-content">
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control"><?php echo getSaying('main'); ?></textarea>
                </div>
                <div class="mb-1 mt-2">
                    <div class="d-flex justify-content-between mt-3">
                        <small class="showonly lines nolines quote">Text in eckigen Klammern [ ] wird hervorgehoben</small>
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
            </div>
            
        </div>
        <input type="hidden" name="iconfile" id="iconfile">
        <input type="hidden" placeholder="Text unter der Linie" name="textafter" id="textafter" value="<?php echo getSaying('lower'); ?>" class="form-control showonly lines nolines quote">
        <input type="hidden" placeholder="Text über der Linie" name="textbefore" id="textbefore" value="" class="form-control showonly lines nolines">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="textColor" id="textColor" value="1">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">