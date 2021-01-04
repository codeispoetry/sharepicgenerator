<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Hilfe
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a href="/documentation" target="_blank" class="dropdown-item"><i class="fas fa-book"></i> Anleitung</a>
            <a href="#" class="overlay-opener dropdown-item" data-target="faq" id="faqopener">
                <i class="fa fa-question-circle"></i> Häufige Fragen
            </a>
            <a href="#" class="overlay-opener dropdown-item" data-target="actiondays" id="actiondaysopener">
                <i class="far fa-hand-point-right"></i> Aktionstage
            </a>
            <a href="/markdown" class="dropdown-item" target="_blank">
                <i class="fas fa-table"></i> Tabelle erstellen
            </a>                   
            <a href="https://www.gruene.de/service/corporate-design" class="dropdown-item" target="_blank">
                <i class="fas fa-tape"></i> Designrichtlinien
            </a>
        </div>
    </li>
    <li class="nav-item">
        <a href="#" class="overlay-opener nav-link" data-target="preferences">Einstellungen</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Über
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a href="https://chatbegruenung.de/channel/sharepicgenerator" class="dropdown-item" target="_blank">
            <i class="fas fa-comment-dots"></i> Feedback</a>
        <a href="https://github.com/codeispoetry/sharepicgenerator" class="dropdown-item" target="_blank">
            <i class="fab fa-github"></i> Quellcode</a>
        </div>
    </li>
    <?php if (configValue($tenant, 'showGallery')) { ?>
        <li class="nav-item">
        <a href="#" class="overlay-opener nav-link" data-target="gallery">Vorlagen</a>
        </li>
    <?php } ?>
    
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Regionale Angebote
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a href="/federal" class="dropdown-item">Deutschland</a>
            <a href="/hessen" class="dropdown-item">Hessen</a>
            <a href="/frankfurt" class="dropdown-item">Frankfurt</a>
        </div>
    </li>
    <li class="nav-item">
        <a href="/imprint.php" class="nav-link"> Impressum</a>
    </li>
    <?php if (isEditor()) { ?>
        <li class="nav-item">
            <a href="log/" class="nav-link font-italic"> Logfiles</a>
        </li>
    <?php } ?>
</ul>

<span class="navbar-text">
    Eingeloggt als 
    <em title="Zuletzt eingeloggt <?php echo getLastLogin(); ?>">
        <?php echo getUser(); ?>
        <?php if (isEditor()) {
            echo '(Editor)';
        }
        ?>
    </em>
    <a href="?logout=true" class="ml-2"><i class="fas fa-sign-out-alt" title="Ausloggen"></i></a>
</span>
