

        <h3><i class="fas fa-text-width"></i> Text</h3>
        <div class="text list-group-item list-group-item-action flex-column align-items-start">
            
            <div class="list-group-item-content">

                <div class="d-flex align-items-lg-center">
                    <textarea placeholder="Text über dem Claim" name="text1" id="text1" class=" form-control h-2em"></textarea>
                </div>
                <div class="d-flex align-items-lg-center">
                    <textarea placeholder="Text unter dem Claim (MdL)" name="text2" id="text2" value="" class="form-control h-3em">    mit Ihrer/Ihrem
  Abgeordneten
VORNAME NACHNAME</textarea>
                         
                </div>  
                    <div class="d-flex align-items-lg-center small">
                        Einrückungen kannst Du mit Leerzeichen einfügen.
                    </div>      
                <div class="d-flex align-items-lg-center">
                    <textarea placeholder="Links unten (Datum und Uhrzeit)" name="text3" id="text3" value="" class="form-control h-3em">WOCHENTAG
DATUM
UHRZEIT</textarea>
                </div>                
                <div class="d-flex align-items-lg-center">
                    <textarea placeholder="Mitte unten, gro0 (Ort)" name="text4" id="text4" value="" class="form-control h-2em">ORT
STADT</textarea>
                </div>         
                <div class="d-flex align-items-lg-center">
                    <textarea placeholder="Mitte unten, klein (Adresse)" name="text5" id="text5" value="" class="form-control h-2em">STRASSE,
PLZ ORT</textarea>
                </div>      
            </div>
        </div>


        <input type="hidden" class="form-range" name="textsize" id="textsize" min="1" max="100">
        <input type="hidden" placeholder="Claim" name="claimtext" id="claimtext" value="" class="form-control showonly area floating">

        <input type="hidden" name="iconfile" id="iconfile">
        <input type="hidden" name="text" id="text" value="vorort">

        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="textColor" id="textColor" value="0">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">
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