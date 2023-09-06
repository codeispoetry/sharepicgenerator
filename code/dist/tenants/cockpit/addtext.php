<h3><i class="fa fa-asterisk"></i> Fließtext</h3>
<div class="addtext list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content">
        <nav class="navbar-expand-lg">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="menu-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Ausrichtung
                    </a>
                    <ul class="dropdown-menu">
                            <li class="align-center-addtext"><span>in Bildmitte</span></li>
                        <li class="to-front" data-target="addtext"><span>in Vordergrund</span></li>
                    </ul>
                </li>
            </ul>   
        </nav>
        <div class="d-flex align-items-lg-center">
            <textarea name="addtext" id="addtext" placeholder="Fließtext" value="" class="form-control"></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="form-range" name="addtextsize" id="addtextsize" min="0"
                    max="50" value="20">
                <small>groß</small>
            </div>
            <div>
                <input type="hidden" name="addtextColor" id="addtextColor" value="<?php getColorAtIndex('addtext'); ?>">
                <span class="colorpicker ms-1" data-colors="<?php getColorAtIndex(); ?>" data-action="addtext.draw()" data-field="#addtextColor" title="Farbe wechseln"></span> 
            </div>
        </div>    
    </div>
</div>

<input type="hidden" name="addtextX" id="addtextX" value="10">
<input type="hidden" name="addtextY" id="addtextY" value="10">
<input type="hidden" name="addtextFont" id="addtextFont" value="PT Sans">
