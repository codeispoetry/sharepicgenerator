<h3><i class="fas fa-images"></i> Vordergrundbilder</h3>
        <div class="addpictures list-group-item list-group-item-action flex-column align-items-start">
            <div class="flex-column align-items-start">
                <?php
                for ($i = 1; $i <=5; $i++) {
                    $divclass='mb-1 list-group-item-content';
                    if ($i > 1) {
                        $divclass .= ' show-add-pic-upload d-none';
                    }
                ?>
                    <div class="<?= $divclass; ?> show-add-pic-all show-add-pic-<?= $i; ?>">
                        <div class="d-flex w-100 justify-content-between">
                         <span class="text-cockpit cursor-pointer addpicclicker<?= $i; ?>">
                            <i class="fa fa-upload"></i> <?= $i; ?>. Bild hochladen
                        </span>


                        <div class="add-pic-tools-<?= $i; ?> text-cockpit d-none">
                            <?php if ($i >= 2) { ?>

                                <span id="addpic-same-x-<?= $i; ?>">
                                    <i class="fas fa-caret-left" title="Gleiche x-Position wie Bild 1"></i>
                                 </span>
                                 <span id="addpic-same-y-<?= $i; ?>">
                                    <i class="fas fa-caret-up" title="Gleiche y-Position wie Bild 1"></i>
                                 </span>
                                <span class="text-cockpit cursor-pointer addpic-same-height-<?= $i; ?>">
                                    <i class="fas fa-arrows-alt-v" title="gleiche Höhe wie Bild 1"></i>
                                </span>
                                <span class="text-cockpit cursor-pointer addpic-same-width-<?= $i; ?>">
                                    <i class="fas fa-arrows-alt-h" title="gleiche Breite wie Bild 1"></i>
                                </span>
                            <?php } ?>
                            
                            <span class="to-front" data-target="addPic<?= $i;?>" title="Bild nach vorne">
                                <i class="fas fa-layer-group text-cockpit"></i>
                            </span>                          
                        
                            <span id="addpicdelete<?= $i; ?>">
                                <i class="fas fa-trash" title="löschen"></i>
                            </span>
                            </div>
                        </div>
                        <div class="mb-1 mt-2 d-none add-pic-tools-<?= $i; ?>">
                            <div class="d-flex align-items-center">
                               <div class="slider">
                                    <small>klein</small>
                                    <input type="range" class="form-range" name="addPicSize<?= $i; ?>" id="addPicSize<?= $i; ?>" min="1" max="800" value="90">
                                    <small>groß</small>
                                </div>
                            </div>
                            <div>
                                <div class="ms-3">
                                    <input type="checkbox" name="addpicrounded<?= $i; ?>" class="retoggle" id="addpicrounded<?= $i; ?>" data-size="xs" data-toggle="toggle" data-on="rund" data-off="eckig">
                                    <input type="checkbox" name="addpicroundedborder<?= $i; ?>" class="retoggle" id="addpicroundedborder<?= $i; ?>" data-size="xs" data-toggle="toggle" data-on="mit&nbsp;Rand" data-off="randlos">
                                </div>
                            </div>
    
                        </div>
                    </div>

                <?php } ?>
            </div>
         </div>
         <?php for($i=1; $i <= 5; $i++) { ?>
            <input type="hidden" name="addpicfile<?php echo $i;?>" id="addpicfile<?php echo $i;?>">
            <input type="hidden" name="addPic<?php echo $i;?>x" id="addPic<?php echo $i;?>x">
            <input type="hidden" name="addPic<?php echo $i;?>y" id="addPic<?php echo $i;?>y">
            <input type="file" class="custom-file-input upload-file" id="uploadaddpic<?php echo $i;?>" accept="image/*">
        <?php } ?>
