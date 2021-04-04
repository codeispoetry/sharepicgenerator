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
        </div>
    </li>
    <li class="nav-item">
        <a href="#" class="overlay-opener nav-link" data-target="preferences">Einstellungen</a>
    </li>
    <li class="nav-item">
        <a href="/imprint.php" class="nav-link"> Impressum</a>
    </li>
</ul>

<?php if(!isGuest()){ ?>
<span class="navbar-text">
    Eingeloggt als 
    <em title="Zuletzt eingeloggt <?php echo getLastLogin(); ?>">
        <?php echo substr(getUser(), 3); ?>
        <?php if (isEditor()) {
            echo '(Editor)';
        }
        ?>
    </em>
    <a href="<?php echo get_logout_link(); ?>" class="ml-2"><i class="fas fa-sign-out-alt" title="Ausloggen"></i></a>
</span>
<?php } ?>
