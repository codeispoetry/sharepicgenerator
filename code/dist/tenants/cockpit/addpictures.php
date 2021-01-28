<h3 class="KILLcollapsed expertmode" data-toggle="collapse" data-target=".addpictures"><i class="fas fa-images"></i> Vordergrundbilder</h3>
        <div class="addpictures expertmode collapse list-group-item list-group-item-action flex-column align-items-start">
            <div class="flex-column align-items-start">
                <?php
                for ($i = 1; $i <=5; $i++) {
                    $divclass='mb-1 list-group-item-content';
                    if ($i > 1) {
                        $divclass .= ' show-add-pic-upload d-none';
                    }
                ?>
                    <div class="<?= $divclass; ?> show-add-pic-<?= $i; ?>">
                        <div class="d-flex w-100 justify-content-between">
                         <span class="text-primary cursor-pointer addpicclicker<?= $i; ?>">
                            <i class="fa fa-upload"></i> <?= $i; ?>. Bild hochladen
                        </span>

                        <div class="text-primary cursor-pointer d-none">
                            <?php if ($i == 2) { ?>
                                <span class="text-primary cursor-pointer d-none show-add-pic-<?= $i; ?>" id="addpicalign" data-click="addpicAlign">
                                    <i class="fas fa-align-justify" title="angleichen"></i>
                                </span>
                            <?php } ?>
                            
                            <span class="to-front" data-target="addPic<?= $i;?>" title="Bild nach vorne">
                                <i class="fas fa-layer-group text-primary"></i>
                            </span> 
                        
                            <span id="addpicdelete<?= $i; ?>">
                                <i class="fas fa-trash" title="löschen"></i>
                            </span>
                            </div>
                        </div>
                        <div class="mb-1 mt-2 d-none show-add-pic-<?= $i; ?>">
                            <div class="d-flex align-items-center">
                               <div class="slider">
                                    <small>klein</small>
                                    <input type="range" class="custom-range" name="addPicSize<?= $i; ?>" id="addPicSize<?= $i; ?>" min="1" max="100" value="15">
                                    <small>groß</small>
                                </div>
                                <div class="ml-3">
                                    <input type="checkbox" name="addpicrounded<?= $i; ?>" class="retoggle" id="addpicrounded<?= $i; ?>" data-size="xs" data-toggle="toggle" data-on="rund" data-off="eckig">
                                    <input type="checkbox" name="addpicroundedbordered<?= $i; ?>" class="retoggle" id="addpicroundedbordered<?= $i; ?>" data-size="xs" data-toggle="toggle" data-on="mit&nbsp;Rand" data-off="randlos">
                                </div>
                            </div>
                            <div>
                                <div class="slider">
                                    <small>nach&nbsp;links</small>
                                    <input type="range" class="custom-range" name="addPicClipHorizontal<?= $i; ?>" id="addPicClipHorizontal<?= $i; ?>" min="-800" max="800" value="15">
                                    <small>nach&nbsp;rechts</small>
                                </div>
                                <div class="slider">
                                    <small>kleiner</small>
                                    <input type="range" class="custom-range" name="addPicClipWidth<?= $i; ?>" id="addPicClipWidth<?= $i; ?>" min="0" max="3000" value="15">
                                    <small>größer</small>
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