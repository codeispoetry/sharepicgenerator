

        <h3>Text</h3>
        <div class="text list-group-item list-group-item-action flex-column align-items-start">   
            <div class="list-group-item-content">                 
                <nav class="navbar-expand-lg">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="menu-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Bearbeiten
                            </a>
                            <ul class="dropdown-menu">                       
                                <li class="textShadowTrigger">
                                    <span>Schatten unter Text</span>
                                </li>

                                <li class="align-center-text"><span>in Bildmitte</span></li>
                                <li class="to-front" data-target="floating"><span>in Vordergrund</span></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="menu-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Schriftart
                            </a>
                            <ul class="dropdown-menu font">                     
                                <?php foreach ($fonts as $font) { ?>
                                    <li class="font-item" data-font="<?php echo basename($font, '.woff2'); ?>">
                                        <span><?php echo basename($font, '.woff2'); ?></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                    <input type="hidden" name="textFont" id="textFont" value="Arial">
                    <input type="checkbox" class="d-none" name="textShadow" id="textShadow" value="on">
                </nav>
           
                <div class="d-flex">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control">Dein Text hier.</textarea>
                    <input type="color" class="form-control" name="textcolor" class="change-text" id="textcolor" value="#000000">
                </div>
                <div class="mb-1 mt-2">
                    <div class="d-flex">
                        <span class="btn btn-sm btn-outline-cockpit textscale me-2" data-scale="0.9">kleiner</span>
                        <span class="btn btn-sm btn-outline-cockpit textscale" data-scale="1.1">größer</span>
                        <input type="hidden" name="textscaled" id="textscaled" value="1">
                    </div> 
                </div>
            </div>
        </div>
        <input type="hidden" name="textFloating" id="textFloating">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="textColor" id="textColor" value="0">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">