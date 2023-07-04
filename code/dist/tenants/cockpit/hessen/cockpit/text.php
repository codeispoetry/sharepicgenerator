

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
                                <li class="d-none">
                                    <span class="text-align" data-align="left" title="linksbündig"><i class="fa fa-align-left"></i></span>
                                    <span class="text-align" data-align="middle" title="zentriert"><i class="fa fa-align-center"></i></span>
                                    <span class="text-align" data-align="end" title="rechtsbündig"><i class="fa fa-align-right"></i></span>
                                </li>
                                <li class="d-flex special-chars">
                                    <span>CO₂</span>
                                    <span>•</span>
                                    <span>„</span><span>“</span>
                                    <span>°</span>
                                </li>
                            


                                <li class="d-none">
                                    <label>
                                        <input type="checkbox" name="textShadow" id="textShadow" value="on">
                                        Schatten unter Text
                                    </label>
                                </li>

                                <li class="d-none">
                                    <label>
                                        <input type="checkbox" name="bottomVariant" id="bottomVariant" value="on">
                                        Text unten vor grün
                                    </label>
                                </li>

                                <li class="align-center-text"><span>in Bildmitte</span></li>
                                <li class="to-front" data-target="floating"><span>in Vordergrund</span></li>
                            </ul>
                        </li>
                        
                        <?php if (configValue('Main', 'enableOpenAi')) { ?>
                        <li class="nav-item dropdown">
                            <a class="menu-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Hilfe
                            </a>
                            <ul class="dropdown-menu">
                                <li class="ai-suggest-trigger">Textvorschläge</li>
                            </ul>   
                        </li>
                        <?php } ?>
                    </ul>
                </nav>
           
                <div class="d-flex align-items-lg-center">
                    <input type="text" placeholder="Text darüber" name="textbefore" id="textbefore" value="" class="d-none form-control">
                    <input type="hidden" name="textbeforecolor" class="change-text" id="textbeforecolor" value="<?php getColorAtIndex(2); ?>">
              
                </div>
                <div class="d-flex">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control">Damit alle alles
!erreichen
können.</textarea>
                    <input type="hidden" name="textcolor" class="change-text" id="textcolor" value="<?php getColorAtIndex(2); ?>">
                    <span 
                        class="colorpicker ms-1"  
                        id="textcolorpicker" 
                        data-colors="<?php getColorAtIndex(); ?>" 
                        data-action="floating.draw()" 
                        data-field="#textcolor" 
                        title="Farbe wechseln"></span> 
                </div>
                <small>Zeilen, die mit einem Ausrufezeichen ! beginnen, werden herborgehoben.</small>
                <div class="d-none align-items-lg-center">
                    <textarea placeholder="Text unter der Linie"  name="textafter" id="textafter" value="" class="form-control h-1em"></textarea>
                    <input type="hidden" name="textaftercolor" class="change-text" id="textaftercolor" value="<?php getColorAtIndex(2); ?>">
                    <span 
                        class="colorpicker ms-1"  
                        id="textaftercolorpicker" 
                        data-colors="<?php getColorAtIndex(); ?>" 
                        data-action="floating.draw()" 
                        data-field="#textaftercolor" 
                        title="Farbe wechseln"></span> 
                </div>
                <div class="d-none justify-content-between">
                    <div class="">
                        <input type="text" placeholder="Claim" name="claimtext" id="claimtext" value="" class="form-control">
                    </div>    
                    <div>
                        <input type="hidden" name="claimcolor" id="claimcolor" class="change-text"  value="#ffe100">
                        <span class="colorpicker ms-1"  id="claimcolorpicker" data-colors="#ffe100,#FF495D" data-action="floating.draw()" data-field="#claimcolor" title="Farbe wechseln"></span>
                    </div>    
                </div>

                <div class="mb-1 mt-2">
                    <div class="d-flex">
                        <span class="btn btn-sm btn-outline-cockpit textscale me-2 border-0 p-2" data-scale="0.9" title="kleiner">-</span>
                        <input type="range" name="textscaled" id="textscaled" value="1" min="0.5" max="6" step="0.1">
                        <span class="btn btn-sm btn-outline-cockpit textscale border-0 p-2" data-scale="1.1" title="größer">+</span>
                    </div> 
                </div>
            </div>
        </div>
        <input type="hidden" name="textFloating" id="textFloating">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="textColor" id="textColor" value="0">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">