

        <h3><i class="fas fa-text-width"></i> Text</h3>
        <div class="text list-group-item list-group-item-action flex-column align-items-start">
            
            <div class="d-none">
                <label class="me-3">Layout:</label>
                 <label class="me-3">
                    <input type="radio" class="form-check-input layout me-1" name="layout" value="berlintext" checked >Schwebend
                 </label>
            </div>

            <div class="list-group-item-content">
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control">Grün wählen
         für Berlin.</textarea>
               
                    <textarea placeholder="Text darunter" name="textafter" id="textafter" class="form-control">           Klar geht das.</textarea>
                    <small>Die Einrückungen kannst Du mir Leerzeichen zu Beginn einer Zeile erzeugen.</small>
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
                                <span class="cursor-pointer ms-3 text-primary align-center-text">
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

            </div>
        </div>
        <input type="hidden" name="iconfile" id="iconfile">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="textColor" id="textColor" value="0">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">