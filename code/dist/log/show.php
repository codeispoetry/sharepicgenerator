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
            <a href="index.php" class="btn btn-primary btn-md ml-2">Statistik</a>
        </div>
        <div class="col-12 text-center">
            Uhrzeit: <?php echo strftime('%A, %k:%M Uhr'); ?><br>
        </div>
        <div class="col-12 text-center">
            <?php
                show_videos("../tmp/shpic*\.mp4");
            ?>
        </div>
    </div>

    <div class="row">
        <?php
            show_images("../tmp/log*\.jpg");
        ?>
    </div>

    <div class="row">
        <div class="col-12 text-center">
            <!-- <scroll-page id="logos"><h2>Custom Logos</h2></scroll-page> -->
        </div>
        <?php
            //showCustomLogos();
        ?>
    </div>

</div>
</scroll-container>
</html>
