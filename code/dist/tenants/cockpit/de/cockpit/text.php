

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
                <div class="d-flex">
                    <textarea placeholder="Text" name="text" id="text" class="form-control detext">Alles neu
   macht der Mai!
Zeile DREI</textarea>
                    
                   <div>
                    <?php for ($i = 0; $i <= 3; $i++) { ?>
                        <div class="d-flex">
                            <select id="lineColorSet<?php echo $i;?>" class="detext lineColorSet form-select">
                                <optgroup label="Farbkombination">
                                    <option value="sand/tanne">sand/tanne</option>
                                    <option value="tanne/sand">tanne/sand</option>

                                    <option value="klee/sand">klee/sand</option>
                                    <option value="sand/klee">sand/klee</option>

                                    <option value="grashalm/tanne">grashalm/tanne</option>
                                    <option value="tanne/grashalm">tanne/grashalm</option>
                                </optgroup>
                            </select>
                            <select id="lineSize<?php echo $i;?>" class="detext lineSize form-select">
                                <optgroup label="Größe">
                                    <option value="20">S</option>
                                    <option value="30">M</option>

                                    <option value="40">L</option>
                                </optgroup>
                            </select>
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