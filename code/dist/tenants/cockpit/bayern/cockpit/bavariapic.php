<h3><i class="fas fa-images"></i> Freigestelltes Bild</h3>

<div class="addpictures list-group-item list-group-item-action flex-column align-items-start">
    <div class="flex-column align-items-start">
        <?php $i = 1; ?>
        <div class="add-pic-section add-pic-section-<?php echo $i; ?> <?php echo ($i !==1) ? 'd-none' : '';?> ">
            <input type="hidden" name="addpicfile<?php echo $i; ?>" id="addpicfile<?php echo $i; ?>">
            <input type="hidden" name="addPic<?php echo $i; ?>x" id="addPic<?php echo $i; ?>x">
            <input type="hidden" name="addPic<?php echo $i; ?>y" id="addPic<?php echo $i; ?>y">
            <input type="file" class="custom-file-input upload-file" id="uploadaddpic<?php echo $i; ?>" accept="image/*">
     
            <div class="add-pic-clicker<?php echo $i; ?>">
                <span class="text-cockpit cursor-pointer addpicclickerBavaria">
                    <i class="fa fa-upload"></i> Freigestelltes Bild hochladen
                </span>
            </div>
            <div class="add-pic-tools-bavaria d-none">
               
                <div class="slider">
                    <small>klein</small>
                        <input type="range" class="form-range" name="addPicSize<?= $i; ?>" id="addPicSize<?= $i; ?>" min="1" max="800" value="90">
                    <small>groß</small>
                </div>
               

                 <div class="add-pic-buttons">
                     <span class="to-front" data-target="addPic<?= $i; ?>" title="Bild nach vorne">
                        <i class="fas fa-layer-group text-cockpit"></i>
                    </span>
                    <span class="addpicdelete<?= $i; ?>">
                        <i class="fas fa-trash" title="löschen"></i>
                    </span>
                   
                </div>
            </div>

        </div>

    
    </div>
</div>
