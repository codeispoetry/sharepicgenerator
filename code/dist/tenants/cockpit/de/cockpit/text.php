

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
                                <li class="d-flex special-chars">
                                    <span>CO₂</span>
                                    <span>•</span>
                                    <span>„</span><span>“</span>
                                    <span>°</span>
                                </li>

                                <li class="align-center-text"><span>in Bildmitte</span></li>
                                <li class="to-front" data-target="floating"><span>in Vordergrund</span></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <div class="row">
                    <div class="col-10">
                        <textarea placeholder="Text" name="text" id="text" class="form-control detext"></textarea>
                        <small>Einrückungen mit Leerzeichen</small>
                    </div>     
                   <div class="col-2">
                    <?php for ($i = 0; $i <= 10; $i++) { ?>
                        <div class="d-flex">

                            <input type="hidden" id="lineColorSet<?php echo $i;?>" value="sand/tanne">
                            <span class="colorSetPicker me-3" id="colorSetPicker<?php echo $i; ?>" >
                                <i class="fas fa-palette">  </i>
                                <div class="palette-container" id="">
                                    <div class="legend">Farbkombination für Zeile <?php echo $i + 1; ?> <small>(max. 2 Grüntone)</small>:</div>
                                    <div class="palette">
                                        <span class="dot sandtanne" data-i="<?php echo $i; ?>" data-colorset="sand/tanne" title="sand/tanne"></span>
                                        <span class="dot tannesand me-5" data-i="<?php echo $i; ?>" data-colorset="tanne/sand" title="tanne/sand"></span>
                                        <span class="dot klee kleesand" data-i="<?php echo $i; ?>" data-colorset="klee/sand" title="klee/sand"></span>
                                        <span class="dot klee sandklee me-5" data-i="<?php echo $i; ?>" data-colorset="sand/klee" title="sand/klee"></span>
                                        <span class="dot grashalm grashalmtanne" data-i="<?php echo $i; ?>" data-colorset="grashalm/tanne" title="grashalm/tanne"></span>
                                        <span class="dot grashalm tannegrashalm" data-i="<?php echo $i; ?>" data-colorset="tanne/grashalm" title="tanne/grashalm"></span>
                                    </div>
                                </div>
                            </span> 

                            <input type="hidden" name="lineSize<?php echo $i;?>" id="lineSize<?php echo $i;?>" value="100">
                            <span class="sizepicker lineSizer ms-1" id="lineSizer<?php echo $i; ?>" data-sizes="200,300,400" data-labels="S,M,L" data-action="detext.draw()" data-field="#lineSize<?php echo $i;?>" title="Schriftgröße der <?php echo $i+1;?>. Zeile"></span> 

                        </div>
                    <?php } ?>
                   </div>
                </div>

                <div class="mb-1 mt-2">
                    <div class="d-flex">
                        <span class="btn btn-sm btn-outline-cockpit textsize me-2 border-0 p-2" data-scale="0.9" title="kleiner">-</span>
                        <input type="range" name="textsize" id="textsize" class="detext" value="5" min="0.5" max="6" step="0.1">
                        <span class="btn btn-sm btn-outline-cockpit textscale border-0 p-2" data-scale="1.1" title="größer">+</span>
                    </div> 
                </div>
            </div>
        </div>
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">