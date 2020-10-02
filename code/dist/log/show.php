<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/log_functions.php'));

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="theme-color" content="#46962b">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logs</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <style>
        scroll-container {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>
<scroll-container>
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-12 text-center">
            <a href="#logos" class="btn btn-info btn-md">Logos</a>
            <a href="?deleteall=true" class="btn btn-danger btn-md ml-2">alle löschen</a>
            <a href="index.php" class="btn btn-primary btn-md ml-2">Statistik</a>
            <a href="/tenants/federal" class="btn btn-secondary btn-md ml-2">Generator</a>
        </div>

        <div class="col-12 text-center">
            <?php
                $hours = (isset($_GET['deleteall'])) ? 1 : 24;
                deleteFilesInPathOlderThanHours($hours, '../tmp/*');
            ?>
        </div>

        <div class="col-12 text-center">
            <a name="videos"><h2>Videos</h2></a>
            <?php
                show_videos("../tmp/shpic*\.mp4");
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center">
            <h2>Bilder</h2>
        </div>
        <?php
            show_images("../tmp/log*\.jpg");
        ?>
    </div>

    <div class="row">
        <div class="col-12 text-center">
            <scroll-page id="logos"><h2>Custom Logos</h2></scroll-page>
        </div>
        <?php
            showCustomLogos();
        ?>
    </div>

</div>
</scroll-container>
</html>
