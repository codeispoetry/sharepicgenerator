<!-- Version:  <?php system("pwd -P | cut -d '/' -f 6"); ?> -->
<div class="d-flex">

    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

    <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Über
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a href="imprint.php" class="dropdown-item">
                    <i class="fa fa-section"></i> Impressum
                </a>
                <a href="imprint.php" class="dropdown-item">
                    <i class="fa fa-key"></i> Datenschutz
                </a>
            </div>
        </li>

    <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Hilfe
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a href="/documentation" target="_blank" class="dropdown-item"><i class="fas fa-book"></i> Anleitung</a>
                <a href="#" class="overlay-opener dropdown-item" data-target="faq" id="faqopener">
                    <i class="fa fa-question-circle"></i> Häufige Fragen
                </a>
                <a class="dropdown-item" href="https://wolke.netzbegruenung.de/apps/files/?dir=/1_Bundesverband/Design%20%26%20Grafik/%C3%9Cbergangs-Styleguide&fileid=53077561" target="_blank">
                    <i class="fas fa-magic"></i> Styleguide
                </a>
                <a class="dropdown-item" href="https://chatbegruenung.de/channel/sharepicgenerator" target="_blank">
                    <i class="fab fa-rocketchat"></i> Chatkanal
                </a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Regionale Angebote
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a href="/btw21" class="dropdown-item">Bundeslayout</a>

                <div class="dropdown-divider"></div>
                <?php
                $tenants = configValue('Main', 'linkedTenants');
                foreach ($tenants as $key => $value) {
                    (str_contains($value, ',')) ? list($description, $start) = explode(',', $value) : $description = $value;
                    if (isset($start) and $start and strToTime($start) > time()) {
                        continue;
                    }
                    printf(
                        '<a href="/%1$s" class="dropdown-item">%2$s</a>',
                        $key,
                        $description
                    );
                }
                ?>
            </div>
        </li>

    </ul>
</div>

<h3><?php echo @explode(',', configValue('Main', 'linkedTenants')[$tenant])[0]; ?></h3>

<div class="navbar-text d-flex">
    <?php if (isEditor()) {
        printf('<a href="/tenants/%s/log/" class="pe-1 me-1 text-decoration-none">Logfiles</a>', $tenant);
    } ?>
    <em title="Zuletzt eingeloggt <?php echo getLastLogin(); ?>">
        <?php echo getUser(); ?>
        <?php if (isEditor()) {
            echo '(Editor)';
        }
        ?>
    </em>
    <a href="?logout=true" class="ms-2"><i class="fas fa-sign-out-alt" title="Ausloggen"></i></a>
</div>