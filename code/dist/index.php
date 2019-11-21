<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sharepicgenerator Bayern</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
</head>
<body class="">
<div class="container-fluid h-100">
    <div class="row">
        <div class="ml-md-auto">
            <div class="col-12 text-center">
                <h1>Sharepicgenerator Bayern</h1>
            </div>
            <div class="col-12">
                <div id="canvas"></div>
                <div id="message"></div>
            </div>
        </div>
        <div class="ml-md-auto p-3">
            <?php require_once('cockpit.php'); ?>
        </div>
    </div>
</div>

<footer class="fixed-bottom bg-primary p-2 text-white">foo
</footer>




<div class="overlays">
    <div id="pixabay" class="overlay">
        <a href="#" class="close">schließen</a>
        <form>
            <input type="text" class="q" value="berge">
            <input type="submit" i value="suchen">
        </form>
        <div class="results"></div>
    </div>
    <div id="waiting" class="overlay">
        Augenblick bitte
    </div>
</div>

<script src="./vendor/jquery-3.4.1.min.js"></script>
<script src="./vendor/svg.min.js"></script>
<script src="./vendor/svg.draggable.min.js"></script>
<script src="./assets/js/main.min.js"></script>
</body>
</html>