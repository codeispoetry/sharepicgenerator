
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
                    $tenants = configValue('Main','linkedTenants');
                    foreach ($tenants as $key => $value ){   
                        list($description, $start) = explode(',', $value);
                        if($start AND strToTime($start) > time() ){
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
                    <li class="mb-1"><a class="" href="/documentation">Handbuch</a></li>
                    <li class="mb-1"><a class="" href="https://github.com/codeispoetry/sharepicgenerator">Quellcode</a></li>
                    <li class="mb-1"><a class="" href="https://github.com/codeispoetry/sharepicgenerator/issues">Fehler melden</a></li>

                </ul>
            </div>
        </div>
    </div>
</footer>