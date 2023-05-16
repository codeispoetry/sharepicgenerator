
<h3>Elemente</h3>
<div class="elements list-group-item list-group-item-action flex-column align-items-start">   
    <div class="list-group-item-content">                 
        <div class="">
            <?php
                $elements = glob('../assets/mv/elements/*.{jpg,png,gif}', GLOB_BRACE);

                foreach($elements as $element){
                    printf('<img src="%1$s" data-file="%1$s" data-width="100" class="element" alt="Element">', $element);
                }
            ?>
        </div>
        <div class="d-flex justify-content-start">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="form-range" name="elementsize" id="elementsize" min="10"
                    max="100" value="80">
                <small>groß</small>
            </div>
        </div>   
    </div>
</div>
        