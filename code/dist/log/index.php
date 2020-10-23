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
        .graphCanvas{
            display: flex;
            align-items: baseline;
        }
        .graph{
            background: #46962b;
            width: 10px;
            margin-right: 1px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center">
            <h2>Statistiken</h2>
        </div>
        <div class="col-12 text-center mb-3">
            <a href="show.php" class="btn btn-primary btn-sm"><i class="fas fa-images"></i> Zeige die jüngsten Sharepics</a>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="fas fa-users"></i> User</dt>
                <dd>
                    gesamt: <?php echo number_format(getUsers(), 0, ',', '.'); ?>
                        <br>
                    Logzeit seit <?php echo number_format(getLoggingPeriodInDays(), 0, ',', '.'); ?> Tagen
                        <br>
                    täglich: <?php printf("%d", getAverageUserPerDay()); ?>
                        <br>
                    mit eigenem Logo: <?php echo getUserWithCustomLogo(); ?>
                        <br>
                </dd>
            </dl>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="fas fa-download"></i> Downloads</dt>
                <dd>
                    gesamt: <?php echo getDownloads(); ?>
                    <br>
                    täglich: <?php echo getDailyDownloads(); ?>
                    <br>
                    mit Pixabay: <?php echo getPixabay(); ?>
                        (<?php printf('%02d', 100*getPixabay()/getDownloads()); ?>%)
                    <br>

                    für Social Media: <?php echo number_format(getSocialMedia(), 0, ',', '.'); ?>
                        (<?php printf('%02d', 100*getSocialMedia()/getDownloads()); ?>%)

                </dd>
            </dl>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="fas fa-bullhorn"></i> Social Media</dt>
                <dd>
                    <ul>
                        <?php showSocialMedia(); ?>
                    </ul>
                </dd>
            </dl>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="fas fa-sitemap"></i> Mandanten</dt>
                <dd><?php echo showTenants(); ?></dd>
            </dl>
        </div>
     
    </div>
</div>
</body>
</html>
