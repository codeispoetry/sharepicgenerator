

        <h3><i class="fas fa-text-width"></i> Text</h3>
        <div class="text list-group-item list-group-item-action flex-column align-items-start">
            

            <div class="list-group-item-content">
                <div class="d-flex">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control">Politik für die
    ganze Stadt!</textarea>
                    <input type="hidden" name="textcolor1" id="textcolor1" value="#006a52">
                    <span class="colorpicker ms-1" data-colors="#95c11f,#006a52" data-action="berlintext.draw()" data-field="#textcolor1" title="Farbe des Balken setzen"></span> 
                </div>

                <div class="d-flex"> 
                    <textarea placeholder="Text darunter" name="textafter" id="textafter" class="form-control">Klimaschutz & Mobilität</textarea>
                    <input type="hidden" name="textcolor2" id="textcolor2" value="#95c11f">
                    <span class="colorpicker ms-1" data-colors="#95c11f,#006a52" data-action="berlintext.draw()" data-field="#textcolor2" title="Farbe des Balken setzen"></span> 
                </div>
                <div>
                    <small>Die Einrückungen kannst Du mir Leerzeichen zu Beginn einer Zeile erzeugen.</small>
                </div>

                <div class="mb-1 mt-2">
                    <div class="justify-content-between">
                        <div class="slider">
                            <small>klein</small>
                            <input type="range" class="form-range" name="textsize" id="textsize" min="1" max="100">
                            <small>groß</small>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="me-3">
                                <span class="cursor-pointer ms-3 text-cockpit align-center-text">
                                    <i class="fab fa-centercode" title="Text in Bildmitte"></i></span>
                            </div> 
                            <div>
                                <span class="to-front" data-bs-target="text" title="Text nach vorne">
                                    <i class="fas fa-layer-group text-cockpit"></i>
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
        <input type="hidden" name="claimX" id="claimX">
        <input type="hidden" name="claimY" id="claimY">
        <input type="hidden" name="textColor" id="textColor" value="0">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">