<h3>Störer</h3>
<div class="eyecatcher list-group-item list-group-item-action flex-column align-items-start">
    <div class="mb-1 list-group-item-content">
        <nav class="navbar-expand-lg">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="menu-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Ausrichtung
                    </a>
                    <ul class="dropdown-menu">
                            <li class="align-center-eyecatcher"><span>in Bildmitte</span></li>
                        <li class="to-front" data-target="pin"><span>in Vordergrund</span></li>
                    </ul>
                </li>
            </ul>   
        </nav>
        <div class="row">
            <div class="col-10">
                <textarea name="pintext" id="pintext" placeholder="Dein Text" class="form-control" data-maxlines="3"></textarea>
            </div>
            <div class="col-auto">
                    <?php for ($i = 0; $i <= 5; $i++) { ?>
                        <div class="d-flex">
                            <select id="pinLineSize<?php echo $i;?>" class=" pinLineSize depin form-select">
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
        <div class="d-flex justify-content-start">
            <div class="slider">
                <small>klein</small>
                <input type="range" class="form-range" name="eyecatchersize" id="eyecatchersize" min="50"
                    max="300" value="100">
                <small>groß</small>
            </div>
        </div>    
    </div>
</div>

<input type="hidden" name="pinX" id="pinX">
<input type="hidden" name="pinY" id="pinY">