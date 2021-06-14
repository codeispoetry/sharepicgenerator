<h3 class="collapsed" data-toggle="collapse" data-target=".eyecatcher"><i class="far fa-eye"></i> Zweitstimme grün</h3>
<div class="eyecatcher list-group-item list-group-item-action flex-column align-items-start collapse">
    <div class="mb-1 list-group-item-content">
        <div class="d-none align-items-lg-center">
            <textarea name="pintext" id="pintext" placeholder="Störertext. Maximal 2 Zeilen." class="form-control">Zweitstimme
grün
            </textarea>
        </div>
        <div class="d-flex justify-content-between">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="form-range" name="eyecatchersize" id="eyecatchersize" min="20"
                    max="90" value="40">
                <small>groß</small>
            </div>
            <div>
                <span class="to-front" data-target="pin" title="Störer nach vorne">
                    <i class="fas fa-layer-group text-primary"></i>
                </span> 
                <span class="pintoleft" title="Störer nach links">
                    <i class="fas fa-align-left text-primary"></i>
                </span> 
                <span class="pintoright" title="Störer nach rights">
                    <i class="fas fa-align-right text-primary"></i>
                </span> 
            </div>
        </div>    
    </div>
</div>

<input type="hidden" name="pinX" id="pinX">
<input type="hidden" name="pinY" id="pinY">
<input type="hidden" name="pinPosition" id="pinPosition" value="right">
