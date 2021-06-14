<h3 class="collapsed expertmode" data-toggle="collapse" data-target=".quality"><i class="fa fa-signal"></i> Bildqualität</h3>
        <div class="quality expertmode collapse list-group-item list-group-item-action flex-column align-items-start">
            Eine hohe Bildqualität bedeutet auch eine größere Datei.
            <div class="d-flex form-check form-check-inline">
                <label class="">
                    <input type="radio" class="form-check-input fileformat" name="fileformat" value="png" checked>png
                 </label>
                 <label class="ms-5">
                    <input type="radio" class="form-check-input fileformat" name="fileformat" value="jpg">jpg
                 </label>
            </div>
            <div class="slider">
                <small>niedrig</small>
                <input type="range" class="form-range" name="quality" id="quality" min="1"
                    max="99" value="80" disabled>
                <small>hoch</small>
            </div>
        </div>
