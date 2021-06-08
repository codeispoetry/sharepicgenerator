<h3 class="collapsed debug" data-toggle="collapse" data-target=".cloud">Wolke</h3>
        <div class="cloud collapse list-group-item list-group-item-action flex-column align-items-start ">
            <?php
            if (hasCloudCredentials()) {
                echo '<script type="text/javascript">config.hasCloudCredentials = true;</script>';
            }
            ?>

            <div class="d-flex justify-content-between">
                <a href="https://wolke.netzbegruenung.de/apps/files/?dir=/sharepicgenerator" target="_blank">
                    <i class="fas fa-cloud"></i> Meine Wolke
                </a>
                <a href="" class="cloudtokendelete">
                    <i class="fas fa-ban"></i> Zugang zur Wolke trennen
                </a>
            </div>
            <div id="cloudmessage" style="display:none">
                <p class="bg-info p-1 ps-3 text-white">Verbinde mich mit Wolke ...</p>
            </div>
            <div id="cloudnotoken" class="" style="display:none">
                 <div>
                     <a href="https://wolke.netzbegruenung.de/settings/user/security" target="_blank">
                         Neues App-Passwort erstellen
                     </a> |
                    <a href="/documentation/cloud" target="_blank">
                        Anleitung
                    </a>
                 </div>
                Bitte hinterlege Deine App-Passwort aus der Wolke:
                <input type="text"  class="form-control" name="cloudtoken" id="cloudtoken">
                <input type="button" id="cloudtokensave" class="btn btn-sm btn-primary" value="Token speichern">
            </div>
            <div id="cloudhastoken" style="display: none">
                <div>
                    <select class="form-control" id="cloudfiles" disabled>
                        <option value="">lade Sharepics ...</option>
                    </select>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary btn-sm download"  data-cloud="save"><i class="fas fa-cloud-download-alt"></i> in Cloud speichern</button>
                </div>
            </div>
        </div>