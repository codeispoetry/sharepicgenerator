<h3 class=" showonly floating berlintext"><i class="fas fa-fan"></i> Logo</h3>
<div class="logo list-group-item list-group-item-action flex-column align-items-start showonly floating berlintext">           
    <div class="">
        <div class="list-group-item-content">
            <select class="form-select" name="logoposition" id="logoposition">
                <option value="leftupper">links oben</option>
				 <option value="leftcenter">links mitte</option>
				 <option value="leftbottom">links unten</option>

                <option value="rightupper">rechts oben</option>
                <option value="rightcenter">rechts mitte</option>
                <option value="rightbottom">rechts unten</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <div class="slider">
                <small>klein</small>
                    <input type="range" class="form-range" name="logosize" id="logosize" min="1" max="100" value="20">
                <small>groß</small>
            </div>
            <div>
                <span class="to-front" data-target="logo" title="Logo nach vorne">
                    <i class="fas fa-layer-group text-primary"></i>
                </span> 
            </div>
        </div>
    </div>
    
</div>
<input type="hidden" name="logoX" id="logoX" value="380">
<input type="hidden" name="logoY" id="logoY" value="220">
