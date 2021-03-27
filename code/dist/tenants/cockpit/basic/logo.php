<h3 class="collapsed expertmode" data-toggle="collapse" data-target=".logo"><i class="fas fa-fan"></i> Logo</h3>
        <div class="logo expertmode collapse list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 d-flex align-items-lg-center">
                <select class="form-control" name="logoselect" id="logoselect">
                    <optgroup label="Sonnenblume">
                        <option value="sonnenblume">Sonnenblume</option>
                    </optgroup>
            
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

                    <optgroup label="Kein Logo">
                        <option value="void">kein Logo</option>
                    </optgroup>
                </select>
                 <i class="fa fa-upload text-primary cursor-pointer uploadlogoclicker ml-2" title="Eigenes Logo hochladen"></i>
                 <i class="fa fa-trash text-primary cursor-pointer overlay-opener nav-lin ml-2" data-target="preferences" title="Logos löschen"></i>
            </div>

            <div class="mb-1 d-flex align-items-lg-center">
                <select class="form-control" name="logoposition" id="logoposition">
                    <optgroup label="oben">
                        <option value="topleft">links</option>
                        <option value="topcenter">mitte</option>
                        <option value="topright">rechts</option>
                    </optgroup>
                    <optgroup label="unten">
                        <option value="bottomleft">links</option>
                        <option value="bottomcenter">mitte</option>
                        <option value="bottomright">rechts</option>
                    </optgroup>
                </select>
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
        </div>
        <input type="file" class="custom-file-input upload-file" id="uploadlogo" accept="image/*">