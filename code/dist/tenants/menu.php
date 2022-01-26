<div class="d-flex">
   
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
                <a href="https://www.gruene.de/service/corporate-design" class="dropdown-item" target="_blank">
                    <i class="fas fa-tape"></i> Designrichtlinien
                </a>
                <a href="https://wolke.netzbegruenung.de/apps/files/?dir=/1_Bundesverband/Bundestagswahl%202021/Design&fileid=31662066" class="dropdown-item" target="_blank">
                    <i class="fas fa-poll"></i> Design zur Bundestagswahl
                </a>

            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Regionale Angebote
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a href="/btw21" class="dropdown-item">Bundeslayout</a>
                <a href="/federal" class="dropdown-item">altes Layout</a>

                <div class="dropdown-divider"></div>
                <?php
                $tenants = configValue('Main','linkedTenants');
                foreach ($tenants as $key => $value ){
                printf('<a href="/%1$s" class="dropdown-item">%2$s</a>',
                    $key,
                    $value
                );
                }
                ?>
            </div>
        </li>

    </ul>
</div>

<h3><?php echo configValue('Main','linkedTenants')[$tenant]; ?></h3>

<div class="navbar-text d-flex">
    <?php if (isEditor()) { ?> 
            <a href="log/" class="pe-1 me-1 text-decoration-none">Logfiles</a>
    <?php } ?>
    <em title="Zuletzt eingeloggt <?php echo getLastLogin(); ?>">
        <?php echo getUser(); ?>
        <?php if (isEditor()) {
            echo '(Editor)';
        }
        ?>
    </em>
    <a href="?logout=true" class="ms-2"><i class="fas fa-sign-out-alt" title="Ausloggen"></i></a>
</div>
