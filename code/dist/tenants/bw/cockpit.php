<?php
// phpcs:ignoreFile -- mainly html, ignore it

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/gallery_functions.php'));

useDeLocale();

session_start();
readConfig();

if (!isAllowed(false)) {
    header("Location: ". configValue("Main", "logoutTarget"));
    die();
}

?>

<form id="pic">
    <div class="mb-5">

        <h3 class="" data-toggle="collapse" data-target=".picture"><i class="fas fa-image"></i> Hauptbild</h3>
        <div class="picture collapse show list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1">
                <a href="#" class="text-primary cursor-pointer uploadfileclicker">
                    <i class="fa fa-upload"></i> Bild oder Video hochladen
                </a> 
            </div>
            <div>
                <div class="input-group pixabay-select-type">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-images pixabay-selected-type"></i>
                        </button>
                        <div class="dropdown-menu">
                            <span class="dropdown-item pixabay-search-in" data-files="images"><i class="fas fa-images"></i> Bilder</span>
                            <span class="dropdown-item pixabay-search-in" data-files="video"><i class="fas fa-video"></i> Videos</span>
                        </div>
                    </div>

                    <input type="text" class="form-control" id="pixabay-direct-search-q" placeholder="Suchbegriff">
                    <div class="input-group-append">
                        <button type="button" class="input-group-text btn-primary pixabay-direct-search">suchen</button>
                    </div>
                </div>
            </div>
           
            <div class="mt-2 mb-1 list-group-item-content show preferences-pic novideo">
                <div class="slider novideo">
                    <small>klein</small>
                    <input type="range" class="custom-range" name="backgroundsize" id="backgroundsize" min="1"
                           max="1500" value="1200">
                    <small>groß</small>
                </div>

                <div class="slider novideo">
                    <small>schwarzweiß</small>
                    <input type="range" class="custom-range" name="graybackground" id="graybackground" min="0"
                        max="1" value="1" step="0.05">
                    <small>farbig</small>
                </div>

                <div class="slider novideo">
                    <small>scharf</small>
                    <input type="range" class="custom-range" name="blurbackground" id="blurbackground" min="0"
                        max="10" value="0" step="0.5">
                    <small>unscharf</small>
                </div>

                <div class="slider novideo">
                    <small>hell</small>
                    <input type="range" class="custom-range" name="darklightlayer" id="darklightlayer" min="-60"
                        max="60" value="0" step="5">
                    <small>dunkel</small>
                </div>

                <div class="slider novideo">
                    <small>unverändert</small>
                    <input type="range" class="custom-range" name="greenlayer" id="greenlayer" min="0"
                        max="100" value="0" step="5">
                    <small>grün</small>
                </div>

                <small class="text-primary cursor-pointer novideo" id="backgroundreset"><i class="fas fa-align-center"></i>
                    zentrieren
                </small>
                <small class="text-primary cursor-pointer novideo ml-5" id="backgroundflip"><i class="fas fa-exchange-alt"></i>
                    spiegeln
                </small>
            </div>
            <div class="align-items-lg-center show-copyright d-none">
                <div class="d-flex align-items-center">
                    <input type="hidden" name="copyrightPosition" id="copyrightPosition"  value="bottomLeft">

                    <input type="text" placeholder="Bildnachweise" name="copyright" id="copyright" value="" class="form-control">
                    <i class="fa fa-broom ml-1 text-primary cursor-pointer copyright-change-color ml-1" title="Farbe wechseln"></i>
                </div>
            </div>
        </div>   
        
        <h3 class="collapsed" data-toggle="collapse" data-target=".layout"><i class="fas fa-expand-arrows-alt"></i> 
            Größe
            <small class="ml-2">
                <i class="fab fa-instagram"></i>
                <i class="fab fa-facebook"></i>
                <i class="fab fa-twitter"></i>
             </small>
            </h3>
        <div class="layout collapse list-group-item list-group-item-action flex-column align-items-start novideo">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <div class="form-inline">
                    <div class="form-row sizecontainer">
                        <input type="number" class="form-control size" name="width" id="width" step="10">
                        <span class="mt-2 small">x</span>
                        <input type="number" class="form-control size" name="height" id="height" step="10">
                        <span class="mt-2 mr-2 small">Px</span>

                        <select class="form-control" id="sizepresets">
                            <option class="">Vorgabe</option>
                            <?php
                            $sizes = parse_ini_file(getBasePath('ini/picturesizes.ini'), true);
                            foreach ($sizes as $name => $group) {
                                printf('<optgroup label="%s">', $name);
                                foreach ($group as $label => $size) {
                                    list($width, $height, $quality) = preg_split("/[^0-9]/", trim($size));
                                    $socialmediaplatform = preg_replace('/ /', '-', "$name-$label");
                                    printf('<option value="%d:%d" data-socialmediaplatform="%s" data-quality="%s">%s</option>', $width, $height, $socialmediaplatform, $quality, $label);
                                }
                                echo '</optgroup>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <small class="text-primary cursor-pointer" id="sizereset"><i class="fas fa-undo-alt"></i> zurücksetzen</small>
            </div>
        </div>

        <h3 class="" data-toggle="collapse" data-target=".text"><i class="fas fa-text-width"></i> Text</h3>
        <div class="text collapse show list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-none justify-content-between form-check form-check-inline">
                <label class="">
                    <input type="radio" class="form-check-input layout" name="layout" value="lines">Mit Linien
                 </label>
                 <label class="">
                    <input type="radio" class="form-check-input layout" name="layout" value="nolines" checked>Ohne Linien
                 </label>
                 <label class="">
                    <input type="radio" class="form-check-input layout" name="layout" value="invers">Invers
                 </label>
                 <label class="">
                    <input type="radio" class="form-check-input layout" name="layout" value="quote">Zitat
                 </label>
            </div>

            <div class="list-group-item-content">
                <div class="d-none">
                    <input type="text" placeholder="Text über der Linie" name="textbefore" id="textbefore" value=""
                           class="form-control showonly lines nolines">
                </div>
                <div class="">
                    <textarea placeholder="Haupttext" name="text" id="text" class="form-control">Wachsen wir
über uns hinaus.</textarea>
                </div>
                <div class="d-flex align-items-lg-center">
                    <input type="text" placeholder="Text unter der Linie" name="textafter" id="textafter" value="" class="form-control showonly lines nolines quote">
                </div>

                <div class="mb-1 mt-2">
                    <div class="d-flex justify-content-between mt-3">
                        <small class="showonly lines nolines quote">Text in eckigen Klammern [ ] wird gelb</small>
                        <small class="cursor-pointer ml-3 text-primary aligncenter showonly lines nolines quote">
                            <i class="fa fa-align-center"></i>
                            mittig ausrichten</small>
                    </div>
                </div>


                <div class="mb-1 mt-2">
                    <div class="d-flex justify-content-between">
                        <div class="slider">
                            <small>klein</small>
                            <input type="range" class="custom-range" name="textsize" id="textsize" min="1" max="100">
                            <small>groß</small>
                        </div>
                        <div>
                            <span class="to-front" data-target="text" title="Text nach vorne">
                                <i class="fas fa-layer-group text-primary"></i>
                            </span> 
                        </div>
                    </div> 
                    </div>

                <div class="preferences-text">
                    <div class="d-flex justify-content-between">
                        <div class="d-none">
                            <label class="showonly lines">
                                <input type="checkbox" name="textsamesize" id="textsamesize">
                                Zeilen gleich lang
                            </label>
                            <label class="showonly lines">
                                <input type="checkbox" name="greenbehindtext" id="greenbehindtext">
                                Grün hinter Text
                            </label>
                        </div>
                        <label class="showonly lines nolines quote">
                            <input type="checkbox" name="graybehindtext" id="graybehindtext">
                            Grau hinter Text
                        </label>
                    </div>
                </div>
            </div>
            <div class="preferences-text showonly lines d-none">
                <div class="d-flex justify-content-between mt-3">
                    <span class="text-primary cursor-pointer uploadiconclicker">
                        <i class="fa fa-upload"></i> Icon hochladen
                    </span>

                    <span class="text-primary cursor-pointer overlay-opener" data-target="iconoverlay">
                        <i class="fas fa-search"></i> Icon suchen
                    </span>
                </div>
                <div class="mb-1 list-group-item-content d-none iconsizeselectwrapper">
                    <select class="form-control" name="iconsize" id="iconsize">
                        <option value="1">Icon: 1 Zeile hoch</option>
                        <option value="2">Icon: 2 Zeilen hoch</option>
                        <option value="3">Icon: 3 Zeilen hoch</option>
                        <option value="0">Icon entfernen</option>
                    </select>
                </div>
            </div>
        </div>

        <h3 class="collapsed expertmode" data-toggle="collapse" data-target=".addpictures"><i class="fas fa-images"></i> Vordergrundilder</h3>
        <div class="addpictures expertmode collapse list-group-item list-group-item-action flex-column align-items-start">
            <div class="flex-column align-items-start">
                <?php
                for ($i = 1; $i <=2; $i++) {
                    $divclass='mb-1 list-group-item-content';
                    if ($i > 1) {
                        $divclass .= ' show-add-pic-upload d-none';
                    }
                ?>
                    <div class="<?= $divclass; ?>">
                        <div class="d-flex w-100 justify-content-between">
                         <span class="text-primary cursor-pointer addpicclicker<?= $i; ?>">
                            <i class="fa fa-upload"></i> <?= $i; ?>. Bild hochladen
                        </span>

                        <div class="text-primary cursor-pointer d-none show-add-pic-<?= $i; ?>">
                            <?php if ($i == 2) { ?>
                                <span class="text-primary cursor-pointer d-none show-add-pic-<?= $i; ?>" id="addpicalign" data-click="addpicAlign">
                                    <i class="fas fa-align-justify" title="angleichen"></i>
                                </span>
                            <?php } ?>
                            
                            <span class="to-front" data-target="addPic<?= $i;?>" title="Bild nach vorne">
                                <i class="fas fa-layer-group text-primary"></i>
                            </span> 
                        
                            <span id="addpicdelete<?= $i; ?>">
                                <i class="fas fa-trash" title="löschen"></i>
                            </span>
                            </div>
                        </div>
                        <div class="mb-1 mt-2 d-none show-add-pic-<?= $i; ?>">
                            <div class="d-flex align-items-center">
                               <div class="slider">
                                    <small>klein</small>
                                    <input type="range" class="custom-range" name="addPicSize<?= $i; ?>" id="addPicSize<?= $i; ?>" min="1" max="100" value="15">
                                    <small>groß</small>
                                </div>
                                <div class="ml-3">
                                    <input type="checkbox" name="addpicrounded<?= $i; ?>" class="retoggle" id="addpicrounded<?= $i; ?>" data-size="xs" data-toggle="toggle" data-on="rund" data-off="eckig">
                                    <input type="checkbox" name="addpicroundedbordered<?= $i; ?>" class="retoggle" id="addpicroundedbordered<?= $i; ?>" data-size="xs" data-toggle="toggle" data-on="mit&nbsp;Rand" data-off="randlos">
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>
         </div>
         <h3 class="collapsed KILLexpertmode" data-toggle="collapse" data-target=".logo"><i class="fas fa-fan"></i> Logo</h3>
        <div class="logo KILLexpertmode collapse list-group-item list-group-item-action flex-column align-items-start">
            <div class="mb-1 d-flex align-items-lg-center">
                <select class="form-control" name="logoselect" id="logoselect">  
                    <optgroup label="BW">
                        <option value="fanleft">Fächer links</option>
                        <option value="fancenter">Fächer mitte</option>
                        <option value="fanright">Fächer rechts</option>
                    </optgroup>
                    <optgroup label="Sonnenblume">
                        <option value="sonnenblume">Sonnenblume</option>
                        <option value="sonnenblume-weiss">weiße Sonnenblume</option>
                    </optgroup>
                    <optgroup label="Kein Logo">
                        <option value="void">kein Logo</option>
                    </optgroup>
                </select>
                 <i class="fa fa-upload text-primary cursor-pointer uploadlogoclicker ml-2" title="Eigenes Logo hochladen"></i>

            </div>
            <div class="d-flex justify-content-between">
                <div class="slider d-none">
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
         <h3 class="collapsed" data-toggle="collapse" data-target=".eyecatcher"><i class="far fa-eye"></i> Störer</h3>
        <div class="eyecatcher list-group-item list-group-item-action flex-column align-items-start collapse">
            <div class="mb-1 list-group-item-content">
                <div class="d-flex align-items-lg-center">
                    <textarea name="pintext" id="pintext" placeholder="Störertext. Maximal 2 Zeilen." value="" class="form-control height1line"></textarea>
                </div>
                <div class="d-flex align-items-lg-center">
                    <textarea name="pinurl" id="pinurl" placeholder="URL" value="" class="form-control height1line"></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="slider">
                        <small>klein</small>
                        <input type="range" class="custom-range" name="eyecatchersize" id="eyecatchersize" min="50"
                            max="300" value="100" disabled>
                        <small>groß</small>
                    </div>
                    <div>
                        <span class="to-front" data-target="pin" title="Störer nach vorne">
                            <i class="fas fa-layer-group text-primary"></i>
                        </span> 
                    </div>
                </div>    
            </div>
        </div>
        <h3 class="collapsed expertmode" data-toggle="collapse" data-target=".addtext"><i class="fa fa-asterisk"></i> Sternchentext</h3>
        <div class="addtext expertmode list-group-item list-group-item-action flex-column align-items-start collapse">
            <div class="mb-1 list-group-item-content">
                <div class="d-flex align-items-lg-center">
                    <textarea name="addtext" id="addtext" placeholder="Sternchentext" value="" class="form-control"></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="slider">
                        <small>klein</small>
                        <input type="range" class="custom-range" name="addtextsize" id="addtextsize" min="0"
                            max="50" value="20">
                        <small>groß</small>
                    </div>
                    <div>
                        <span class="to-front" data-target="addtext" title="Sternchentext nach vorne">
                            <i class="fas fa-layer-group text-primary"></i>
                        </span> 
                        <i class="fa fa-broom ml-1 text-primary cursor-pointer addtext-change-color ml-1" title="Farbe wechseln"></i>
                    </div>
                </div>    
            </div>
        </div>

        <h3 class="collapsed expertmode showonly nolines quote lines" data-toggle="collapse" data-target=".eraser"><i class="fas fa-eraser"></i> 
            3-D-Effekt
         </h3>
        <div class="eraser expertmode collapse list-group-item list-group-item-action flex-column align-items-start">
           Um eine 3-D-Anmtung zu bekommen, kannst Du Text wegradieren. Dadurch entseht der Eindruck, der 
           Text stünde hinter einem Objekt.
           
            <div class="d-flex justify-content-between mb-2">
                <a class="btn btn-info btn-sm" id="btn-eraser" data-action="on">Radierer einschalten</a>
                <span id="eraser-delete">
                    <i class="fas fa-trash text-primary" title="löschen"></i>
                </span>
            </div>
            <img src="/assets/3d-effekt.jpg" class="img-fluid">
        </div>

        <h3 class="collapsed expertmode" data-toggle="collapse" data-target=".quality"><i class="fa fa-signal"></i> Bildqualität</h3>
        <div class="quality expertmode collapse list-group-item list-group-item-action flex-column align-items-start">
            Eine hohe Bildqualität bedeutet auch eine größere Datei.
            <div class="d-flex form-check form-check-inline">
                <label class="">
                    <input type="radio" class="form-check-input fileformat" name="fileformat" value="png" checked>png
                 </label>
                 <label class="ml-5">
                    <input type="radio" class="form-check-input fileformat" name="fileformat" value="jpg">jpg
                 </label>
            </div>
            <div class="slider">
                <small>niedrig</small>
                <input type="range" class="custom-range" name="quality" id="quality" min="1"
                    max="99" value="80" disabled>
                <small>hoch</small>
            </div>
        </div>


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
                <p class="bg-info p-1 pl-3 text-white">Verbinde mich mit Wolke ...</p>
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

        <h3 class="collapsed expertmode" data-toggle="collapse" data-target=".finish"><i class="fas fa-wrench"></i> Arbeitsdatei</h3>
        <div class="finish expertmode collapse list-group-item list-group-item-action flex-column align-items-start">
            <div>
                Mit der Arbeitsdatei kannst Du Dein Sharepic später weiter bearbeiten.
            </div>
            <div>
                <button type="button" class="btn btn-info btn-sm" id="savework" data-click="savework"><i class="fas fa-download"></i> herunterladen</button>
                <button type="button" class="btn btn-info btn-sm uploadworkclicker" id="uploadworkclicker"><i class="fas fa-upload"></i> hochladen</button>
            </div>
        </div>

        <?php if(configValue($tenant,'showGallery') AND isEditor()){ ?>
            <h3 class="collapsed" data-toggle="collapse" data-target=".gallery"><i class="fas fa-store"></i> 
                Vorlagen
            </h3>
            <div class="gallery collapse list-group-item list-group-item-action flex-column align-items-start">
                <div id="gallery-note" class="text-danger"></div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-info saveInGallery" id='saveInGallery'><i class="fas fa-save"></i> als Vorlage veröffentlichen</button>
                </div>
            </div>
        <?php } ?>

        <h3 class="collapsed d-none" data-toggle="collapse" data-target=".code"><i class="fas fa-code"></i> Code-API</h3>
        <div class="code collapse list-group-item list-group-item-action flex-column align-items-start">
            <div>
                <textarea placeholder="JavaScript-Code" name="code" id="code" class="form-control"></textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-info btn-sm runcode"><i class="fas fa-code"></i> Code ausführen</button>
                <a href="/documentation/code" target="_blank"><i class="fas fa-book"></i> Anleitung</i></a>
            </div>
        </div>

        <div class="text-center text-white mt-3 border-bottom pb-3">
            <div class="d-none d-md-block col-12">
                <span class="small mr-2">Hilflinien:</span>
                <input id="gridlines" type="checkbox" checked 
                    data-width="40" data-size="xs" data-toggle="toggle" data-on="an" data-off="aus">
                
                <span class="small ml-4 mr-2">Mehr Funktionen:</span>
                <input id="expertmode" type="checkbox" 
                    data-width="40" data-size="xs" data-toggle="toggle" data-on="an" data-off="aus">
            </div>
        </div>    

        <div class="text-center text-white mt-3">
            <i class="fas fa-spa text-highlight"></i> Programmiert von
            <a href="MAILTO:mail@tom-rose.de?subject=Sharepicgenerator" class="text-white">Tom Rose</a>.
        </div>
    </div>
    <div class="d-none">
        <input type="hidden" name="pinX" id="pinX">
        <input type="hidden" name="pinY" id="pinY">
        <input type="hidden" name="backgroundX" id="backgroundX">
        <input type="hidden" name="backgroundY" id="backgroundY">
        <input type="hidden" name="backgroundURL" id="backgroundURL">
        <input type="hidden" name="iconfile" id="iconfile">
        <input type="hidden" name="addpicfile1" id="addpicfile1">
        <input type="hidden" name="addpicfile2" id="addpicfile2">
        <input type="hidden" name="fullBackgroundName" id="fullBackgroundName">
        <input type="hidden" name="textX" id="textX">
        <input type="hidden" name="textY" id="textY">
        <input type="hidden" name="addtextX" id="addtextX">
        <input type="hidden" name="addtextY" id="addtextY">
        <input type="hidden" name="addPic1x" id="addPic1x">
        <input type="hidden" name="addPic1y" id="addPic1y">
        <input type="hidden" name="addPic2x" id="addPic2x">
        <input type="hidden" name="addPic2y" id="addPic2y">
        <input type="hidden" name="textColor" id="textColor" value="0">
        <input type="hidden" name="eraser" id="eraser">


        <input type="file" class="custom-file-input upload-file" id="uploadfile" accept="image/*,.heic,video/mp4">
        <input type="file" class="custom-file-input upload-file" id="uploadlogo" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadicon" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadaddpic1" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadaddpic2" accept="image/*">
        <input type="file" class="custom-file-input upload-file" id="uploadwork" accept="application/zip">
    </div>
</form>
