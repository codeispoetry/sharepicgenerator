
<footer class="bg-primary p-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-md">
                <h5>Über</h5>
                <ul class="list-unstyled text-small">
                    <li class="mb-1"><a class="" href="/imprint.php">Impressum</a></li>
                    <li class="mb-1"><a class="" href="MAILTO:tom.rose@sharepicgenerator.de">Kontakt</a></li>
                    <li class="mb-1"><a class="" href="/imprint.php">Datenschutz</a></li>
                    <li class="text-white">Version:
                        <?php
                        system("pwd -P | cut -d '/' -f 6");
                        ?>
                    </li>
                </ul>
            </div>
            <div class="col-6 col-md text-md-center">
                <h5>Sondermodelle</h5>
                <ul class="list-unstyled text-small">
                    <?php
                    $tenants = configValue('Main', 'linkedTenants');
                    foreach ($tenants as $key => $value) { 
                        @list($description, $start) = explode(',', $value);
                        if ($start && strToTime($start) > time()){
                            continue;
                        }
                        printf('<li class="mb-1"><a href="/%1$s" class="">%2$s</a></li>',
                            $key,
                            $description
                        );
                    }
                    ?>


                </ul>
            </div>
            <div class="col-6 col-md text-md-end">
                <h5>Hilfen</h5>
                <ul class="list-unstyled text-small">
                    <li class="mb-1"><a class="" href="/documentation" target="_blank">Handbuch</a></li>
                    <li class="mb-1"><a class="" href="https://wolke.netzbegruenung.de/apps/files/?dir=/1_Bundesverband/Design%20%26%20Grafik/%C3%9Cbergangs-Styleguide&fileid=53077561" target="_blank">Styleguide</a></li>
                    <li class="mb-1"><a class="" href="https://github.com/codeispoetry/sharepicgenerator" target="_blank">Quellcode</a></li>
                    <li class="mb-1"><a class="" href="https://github.com/codeispoetry/sharepicgenerator/issues" target="_blank">Fehler melden</a></li>
                    <li class="mb-1"><a class="" href="https://chatbegruenung.de/channel/sharepicgenerator" target="_blank">Chatkanal</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>