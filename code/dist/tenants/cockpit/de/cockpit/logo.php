<h3 class="">Logo</h3>
<div class="logo list-group-item list-group-item-action flex-column align-items-start showonly floating berlintext">
    <nav class="navbar-expand-lg d-none">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="menu-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    Ausrichtung
                </a>
                <ul class="dropdown-menu">
                    <li class="to-front" data-target="defaultlogo"><span>in Vordergrund</span></li>
                </ul>
            </li>
        </ul>   
    </nav>
    <div class="d-flex justify-content-between">
        <div class="slider me-3">
            <small>klein</small>
                <input type="range" class="form-range" name="logosize" id="logosize" min="1" max="100" value="20">
            <small>groß</small>
        </div>
    </div>   
    <div class="d-flex justify-content-between">
        <select class="form-select" id="logofile">
            <option value="/assets/de/logo.svg">gelb</option>
            <option value="/assets/de/logo-grashalm.svg">grün</option>
        </select>
    </div>   
</div>
<input type="hidden" name="logoX" id="logoX" value="256.5">
<input type="hidden" name="logoY" id="logoY" value="390">

