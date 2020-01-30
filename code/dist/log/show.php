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
            <a href="#logos" class="btn btn-info btn-lg">zu Logos</a>
			<a href="index.php" class="btn btn-primary btn-lg ml-2">Zeige Statistik</a>
		</div>


        <div class="col-12 text-center">
            <?php
                deleteFilesInPathOlderThanDays(1, '../tmp/*');
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
<?php


function show_videos($dir)
{
    $files = array_reverse(glob($dir));

    echo '<ol>';
    foreach ($files AS $file) {
        printf('<li><a href="%s"/>%s</li>', $file, date("d. F Y, H:i", filemtime($file)));
    }
    echo '</ol>';
}

function show_images($dir)
{
    $files = array_reverse(glob( $dir ) );

    foreach ($files AS $file) {
        printf('<div class="col-6 col-md-3 col-lg-2"><img src="%s" class="img-fluid"/></div>', $file);
    }
}


function deleteFilesInPathOlderThanDays($days, $path)
{
    $files = glob($path);
    $now = time();
    $counter = 0;

    foreach ($files AS $file) {
        if (is_file($file) AND $now - filemtime($file) >= 60 * 60 * 24 * $days) {
            $counter++;
            unlink($file);
        }
    }

    printf('%d Dateien gelöscht ', $counter);
}

function showCustomLogos(){
    exec('find ../persistent/user/ -name logo.png', $output);
    foreach( $output AS $file){
        printf('<div class="col-2"><img src="%s" class="img-fluid"></div>', $file);
    }
}