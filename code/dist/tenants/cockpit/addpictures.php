<h3><i class="fas fa-images"></i> Vordergrundbilder</h3>
<?php
    define('COUNT_ADD_PICS', 5);
?>
<div class="addpictures list-group-item list-group-item-action flex-column align-items-start">
    <div class="flex-column align-items-start">
        <?php
        for ($i = 1; $i <= COUNT_ADD_PICS; $i++) {
            $divclass = 'mb-1 list-group-item-content';
            if ($i > 1) {
                $divclass .= ' show-add-pic-upload-' . $i . ' d-none';
            }
            ?>
            <div class="<?= $divclass; ?> show-add-pic-all show-add-pic-<?= $i; ?>">
                <input type="hidden" name="addpicfile<?php echo $i; ?>" id="addpicfile<?php echo $i; ?>">
                <input type="hidden" name="addPic<?php echo $i; ?>x" id="addPic<?php echo $i; ?>x">
                <input type="hidden" name="addPic<?php echo $i; ?>y" id="addPic<?php echo $i; ?>y">
                <input type="file" class="custom-file-input upload-file" id="uploadaddpic<?php echo $i; ?>" accept="image/*">
     
            
                <div class="d-flex w-100 justify-content-between">
                    <span class="text-cockpit cursor-pointer addpicclicker<?= $i; ?>">
                        <i class="fa fa-upload"></i> <?= $i; ?>. Bild hochladen
                    </span>

                    <div class="add-pic-tools-<?= $i; ?> text-cockpit d-none">
                        <input type="text" id="addPicCaption<?= $i; ?>" name="addPicCaption<?= $i; ?>" class="form-control form-control-sm" placeholder="Bildbeschreibung">
                        <div>
                            <input type="hidden" name="addPicCaptionColor<?= $i; ?>" id="addPicCaptionColor<?= $i; ?>" class="change-text"  value="#ffffff">
                            <span class="colorpicker ms-1"  id="claimcolorpicker" data-colors="#ffffff,#000000,#ffe100,#FF495D" data-action="window['addPic<?= $i; ?>'].setCaption()" data-field="#addPicCaptionColor<?= $i; ?>" title="Farbe wechseln"></span>
                        </div>   
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

                        <span class="to-front" data-target="addPic<?= $i; ?>" title="Bild nach vorne">
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
                            <label><input type="checkbox" name="addpicrounded<?= $i; ?>"  id="addpicrounded<?= $i; ?>">Rund</label>
                            <label><input type="checkbox" name="addpicroundedborder<?= $i; ?>"  id="addpicroundedborder<?= $i; ?>">Rand</label>
                        </div>
                    </div>

                </div>
            </div>

        <?php } ?>
    </div>
</div>
