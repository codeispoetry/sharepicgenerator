

<h3>Text</h3>
<div class="text list-group-item list-group-item-action flex-column align-items-start">
    
    <div class="d-block list-group-item-content">
        
        <div class="d-none align-items-lg-center">
            <input type="text" placeholder="Text darüber" name="textbefore" id="textbefore" value="" class="form-control">
        </div>
        <?php for ($i=1; $i <= 3; $i++) {
            $texts = array(null, 'Sicher', 'radeln.', 'Jetzt!');
            ?>
        <div class="d-flex">
            <textarea placeholder="Text" name="text<?php echo $i; ?>" id="text<?php echo $i; ?>" class="form-control text-trigger"><?php echo $texts[$i]; ?></textarea>
            <input type="hidden" name="textX<?php echo $i; ?>" id="textX<?php echo $i; ?>">
            <input type="hidden" name="textY<?php echo $i; ?>" id="textY<?php echo $i; ?>">
            <input type="hidden" name="textcolor<?php echo $i; ?>" id="textcolor<?php echo $i; ?>" value="<?php getColorAtIndex(2); ?>">
            <span 
                class="colorpicker ms-1"  sd
                id="textcolorpicker" 
                data-colors="<?php getColorAtIndex(); ?>" 
                data-action="floating.draw(<?php echo $i; ?>)" 
                data-field="#textcolor<?php echo $i; ?>" 
                title="Farbe wechseln"></span> 
        </div>
        <?php } ?>

        <div class="mb-1 mt-2">
            <div class="d-flex justify-content-between">
                <a class="btn btn-sm btn-outline-cockpit textscale" data-scale="0.9">kleiner</a>
                <span class="btn btn-sm btn-outline-cockpit textscale" data-scale="1.1">größer</span>
            </div> 
        </div>
        
    </div>
</div>
