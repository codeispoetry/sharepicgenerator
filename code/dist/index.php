<?php
$samlfile = '/var/simplesaml/lib/_autoload.php';

if (file_exists($samlfile)) {
    require_once($samlfile);
    $as = new SimpleSAML_Auth_Simple('default-sp');
    $as->requireAuth();
}
//$samlattributes = $as->getAttributes();
//if (isset($samlattributes)) {
//    $user = $samlattributes['urn:oid:0.9.2342.19200300.100.1.1'][0];
//    // do nothing
//}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <title>Sharepicgenerator</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="col-12 text-center pt-4 pb-3">
                <h1 class="text-uppercase">Sharepicgenerator (Preview)</h1>
            </div>
            <div class="col-12">
                <div id="canvas"></div>
            </div>
            <div class="col-12 mt-3 mb-3">
                <div id="message" class="bg-danger text-white p-4" style="display:none"></div>
            </div>

            <div class="col-12 text-center mb-5">
                <button class="btn btn-secondary btn-lg" id="download">
                    <i class="fas fa-download"></i> Herunterladen
                </button>
            </div>


        </div>
        <div class="col-12 col-lg-3 mt-3 mb-5 cockpit">
            <?php require_once('cockpit.php'); ?>
        </div>
    </div>
</div>

<footer class="row bg-primary p-2 text-white">
    <div class="col-12 col-lg-8">
        <a href="https://github.com/codeispoetry/sharepicgenerator" target="_blank">Quellcode auf
            github.com</a>
    </div>
    <div class="col-12 col-lg-5 d-none">
        <a href="#" class="persistentsave">Als Vorlage speichern</a>

        <?php foreach (glob("persistent/*.json") as $filename) { ?>
            | <a href="#" class="persistentpic" data-pic="<?php echo $filename;?>"><?php echo ucfirst(basename($filename, '.json'));?></a>
        <?php } ?>
    </div>
    <div class="col-12 col-lg-4 text-lg-right">
        Programmiert mit <i class="fas fa-heart text-danger"></i> von Tom Rose.
    </div>
</footer>


<div class="overlays">
    <div id="pixabay" class="overlay">
        <div class="container-fluid">
            <a href="#" class="close text-danger">
                <i class="fas fa-times"></i>
            </a>
            <div class="row pt-2 mt-1">
                <div class="col-12 text-center">
                    <h2>Bilder suchen</h2>
                </div>
                <div class="col-4 offset-4" id="pixabay">
                    <form>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-images"></i></div>
                            </div>
                            <input type="text" class="form-control q" placeholder="z.B. Berge oder Sonnenblume">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text btn-primary">Suchen</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 p-5 results"></div>
        </div>

    </div>


    <div id="waiting" class="overlay text-danger bg-light">
        <h1>Augenblick bitte</h1>
    </div>
</div>

<script>
    <?php echo 'const config ='; @readfile('config.json') || readfile('config-sample.json'); ?>
</script>
<script src="./vendor/jquery-3.4.1.min.js"></script>
<script src="./vendor/svg.min.js"></script>
<script src="./vendor/svg.draggable.min.js"></script>
<script src="./assets/js/main.min.js"></script>
</body>
</html>