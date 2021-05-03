<h3 class="collapsed expertmode" data-toggle="collapse" data-target=".logo"><i class="fas fa-fan"></i> Logo</h3>
        <div class="logo expertmode collapse list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 d-flex align-items-lg-center">
                <select class="form-control" name="logoselect" id="logoselect">
                    <optgroup label="Sonnenblume">
                        <option value="sonnenblume">Sonnenblume</option>
                        <option value="sonnenblume-weiss">weiße Sonnenblume</option>
                        <option value="sonnenblume-big">Sonnenblume links unten</option>
                    </optgroup>
                    <optgroup label="Logo mit Schriftzug">
                        <option value="logo-weiss">weiß, mit Schriftzug</option>
                        <option value="logo-gruen">grün, mit Schriftzug</option>
                    </optgroup>

                    <?php
                    if ($landesverband == 3) {
                        ?>
                    <optgroup label="Berlin">
                        <option value="logo-berlin-gruen">Berliner Logo in grün</option>
                        <option value="logo-berlin-weiss" selected>Berliner Logo in weiß</option>
                    </optgroup>
                    <?php
                    }
                    ?>
                    
                    <?php
                        $logos = glob(getBasePath('persistent/user/' . $user . '/logo*'));
                        if (!empty($logos)) {
                    ?>
                        <optgroup label="Eigene Logos">
                        <?php
                            $i = 1;
                            foreach($logos as $logo) {
                                printf('<option value="custom" data-file="%s">Logo #%s</option>', $logo, $i);
                                $i++;
                            }
                        ?>
                        </optgroup>
                    <?php
                        }
                    ?>
                   
                    <optgroup label="Speziallogos">
                        <option value="frauenrechte">Frauenrechte</option>
                        <option value="regenbogen">Regenbogen</option>
                        <option value="europa">Europa</option>
                        <option value="gruene-alte">Grüne Alte</option>

                    </optgroup>
                    <optgroup label="Kein Logo">
                        <option value="void">kein Logo</option>
                    </optgroup>
                </select>
                 <i class="fa fa-upload text-primary cursor-pointer uploadlogoclicker ml-2" title="Eigenes Logo hochladen"></i>
                 <i class="fa fa-trash text-primary cursor-pointer overlay-opener nav-lin ml-2" data-target="preferences" title="Logos löschen"></i>

            </div>
            <div class="">
                <input type="text" placeholder="Text im blauen Balken: KV oder OV" name="logochapter" id="logochapter" value=""
                        class="form-control form-control-sm">
            </div>
            <div class="d-flex justify-content-between">
                <div class="slider">
                    <small>klein</small>
                        <input type="range" class="custom-range" name="logosize" id="logosize" min="1" max="100" value="10">
                    <small>groß</small>
                </div>
                <div>
                    <span class="to-front" data-target="logo" title="Logo nach vorne">
                        <i class="fas fa-layer-group text-primary"></i>
                    </span> 
                </div>
            </div>
            <div class="">
                Erstelle Dein OV-Logo mit dem <a href="https://logo.sharepicgenerator.de" target="_blank">Logogenerator</a>.
            </div>
        </div>
        <input type="file" class="custom-file-input upload-file" id="uploadlogo" accept="image/*">