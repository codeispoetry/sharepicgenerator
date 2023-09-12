

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
                    <div class="col-8">
                        <textarea placeholder="Text" name="text" id="text" class="form-control detext"></textarea>
                        <small>Einrückungen mit Leerzeichen</small>
                    </div>     
                   <div class="col-auto">
                    <?php for ($i = 0; $i <= 10; $i++) { ?>
                        <div class="d-flex">
                            <select id="lineColorSet<?php echo $i;?>" class="w-75 detext lineColorSet form-select" title="Es sind höchstens 2 Grüntöne gleichzeitig möglich">
                                <optgroup label="Farbkombination">
                                    <option value="sand/tanne" class="sandtanne">sand/tanne</option>
                                    <option value="tanne/sand" class="tannesand">tanne/sand</option>
                                    <option value="klee/sand" class="klee kleesand" data-disable=".grashalm">klee/sand</option>
                                    <option value="sand/klee" class="klee sandklee" data-disable=".grashalm">sand/klee</option>
                                    <option value="grashalm/tanne" class="grashalm grashalmtanne" data-disable=".klee">grashalm/tanne</option>
                                    <option value="tanne/grashalm" class="grashalm tannegrashalm" data-disable=".klee">tanne/grashalm</option>
                                </optgroup>
                            </select>

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