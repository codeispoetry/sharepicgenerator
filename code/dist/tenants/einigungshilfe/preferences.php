<div class="col-12">
    <div id="preferences" class="overlay" style="display:none;">
        <a href="#" class="close closer text-danger" data-target="#preferences">
            <i class="fas fa-times"></i>
        </a>
        <h2>Einstellungen </h2>

        <div class="row">
            <div class="col-12">
                <h3>Logos </h3>
                <span class="text-cockpit cursor-pointer uploadlogoclicker ms-2" title="Eigenes Logo hochladen">
                    <i class="fa fa-upload"></i>
                    Neues Logo hochladen</span>
            </div>
        </div>
        <div class="row">
            <?php
            $logos = glob(getBasePath('persistent/user/' . $user . '/logo*'));
   
            if (!empty($logos)) {
                $i = 1;
                foreach ($logos as $logo) {
                    ?>
                <div class="col-6 col-md-3 col-lg-3">
                    <figure class="samplesharepic">
                        <img src="<?php echo $logo; ?>" class="img-fluid">

                        <figcaption class="d-flex justify-content-around align-items-center">
                            <table class="small m-2">
                                <tbody>
                                    <tr>
                                        <td class="pe-3"></td>
                                        <td><a data-file="<?php echo basename($logo);?>" class="delete-logo text-danger cursor-pointer">
                                        <i class="fas fa-trash"></i> löschen</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </figcaption> 
                    </figure>
                </div>

                    <?php
                    $i++;
                }
            }
            ?>
        </div>    
        <div class="row mt-3">
            <div class="col-12">
                <h3>Schriften</h3>
                <label class="uploadfontclicker">Schrift hochladen:
                    <i class="fa fa-upload text-cockpit cursor-pointer ms-2" title="Schrift hochladen"></i>
                </label>
                <?php
                foreach (glob("{../../persistent/fonts/" . getUser() . "*.woff2}", GLOB_BRACE) as $font) {
                    $font_file = basename($font, '.woff2');
                    $font_family =  getFontFamily($font_file);
                    printf('<li>%s, <a href="#" data-file="%s" class="delete-font text-danger"> <i class="fas fa-trash"></i> löschen</a></li>', $font_family, $font_file);
                }
                ?>

            </div>
        </div> 
    </div>
</div>