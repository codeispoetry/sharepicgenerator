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
        <div class="d-flex align-items-lg-center">
            <textarea name="pintext" id="pintext" placeholder="Dein Text" class="form-control" data-maxlines="3">Hallo</textarea>
        </div>
        <div class="d-flex justify-content-start">
            <div class="slider advancedmode d-none">
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