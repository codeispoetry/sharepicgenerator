<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/log_functions.php'));

setlocale(LC_TIME, ' de_DE.UTF-8', 'de_DE.utf8');
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="theme-color" content="#46962b">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logs</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
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
        <div class="col-12">
            <h4>Systemgesundheit</h4>
            Uhrzeit: <?php echo strftime('%A, %k:%M Uhr'); ?><br>
            Freier Festplattenplatz: <?php echo getFreeSpace(); ?>
        </div>
        <div class="col-12 pb-5">
            <?php showLogGraph();?>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="fas fa-users"></i> User</dt>
                <dd>
                    <?php
                        $totalDownloads = getDownloads();
                    ?>
                    gesamt: <?php echo number_format(getUsers(), 0, ',', '.'); ?>
                        <br>
                    heute: <?php echo number_format(getDownloadsLastDay(0), 0, ',', '.'); ?>
                        <br>
                    gestern: <?php echo number_format(getDownloadsLastDay(1), 0, ',', '.'); ?>
                        <br>
                     vorgestern: <?php echo number_format(getDownloadsLastDay(2), 0, ',', '.'); ?>
                        <br>
                    letzten 30 Tage: <?php echo number_format(getUsersLastDays(30), 0, ',', '.'); ?>
                        <br>
                    Aktivität (Median): <?php echo number_format(getUsersActivity(), 0, ',', '.'); ?>
                        <br>
                    User (1 Login, 30 Tage): <?php echo number_format(getLoginCountsPerUserLastDays('=', 1, 30), 0, ',', '.'); ?>
                        <br>
                    User(>=4 Logins, 30 Tage): <?php echo number_format(getLoginCountsPerUserLastDays('>=', 4, 30), 0, ',', '.'); ?>
                        <br>
                    Logzeit seit <?php echo number_format(getLoggingPeriodInDays(), 0, ',', '.'); ?> Tagen
                        <br>
                    täglich: <?php echo number_format(getDailyUsers(), 0, ',', '.'); ?>
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
                    gesamt: <?php echo number_format(getDownloads(), 0, ',', '.'); ?>
                    <br>
                    unique sharepics: <?php echo 100 * round(getUniqueDownloads() / getDownloads(), 2); ?>%
                    <br>
                    täglich: <?php echo number_format(getDailyDownloads(), 0, ',', '.'); ?>
                    <br>
                    grünifiziert: <?php printf('%2d', 100*getGreenifyRelative()); ?>%
                    <br>
                    für Social Media: <?php printf('%2d', 100*getSocialMedia()/$totalDownloads); ?>%
                    <br>
                    mit Zusatzbild: <?php printf('%2d', 100*getAddPic()/$totalDownloads); ?>%
                        <br>
                    mit Störer: <?php printf('%2d', 100*getWithEyecatcher()/$totalDownloads); ?>%
                    <br>
                    mit Sternchentext: <?php printf('%2d', 100*getAddText()/$totalDownloads); ?>%
                    <br>
                    mit 3-D-Effekt: <?php printf('%.1f', 100*getEraser()/$totalDownloads); ?>%
                </dd>
            </dl>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="far fa-time"></i> Zeiten der letzten 7 Tage</dt>
                <dd>
                    Median Createtime: <?php echo round(getMedianCreatingTime()/1000, 1); ?>s<br>
                    80% Createtime: <?php echo round(getMedianCreatingTime(80)/1000, 1); ?>s<br>
                    90% Createtime: <?php echo round(getMedianCreatingTime(90)/1000, 1); ?>s<br>
                    Mittel Createtime: <?php echo round(getAvgCreatingTime()/1000, 1); ?>s
                </dd>
                <dd>
                    Median Uploadtime: <?php echo round(getMedianUploadTime()/1000, 1); ?>s<br>
                    80% Uploadtime: <?php echo round(getMedianUploadTime(80)/1000, 1); ?>s<br>

                    Mittel Uploadtime: <?php echo round(getAvgUploadTime()/1000, 1); ?>s
                </dd>
            </dl>
        </div>
        <div class="col-6 col-md-6 col-lg-3 d-none">
            <dl>
                <dt><i class="far fa-images"></i> Bildquellen</dt>
                <dd>
                    <ul>
                        <?php //showBackgroundSources(); ?>
                    </ul>
                </dd>
            </dl>
        </div>
        <div class="col-6 col-md-6 col-lg-3 d-none">
            <dl>
                <dt><i class="fas fa-bullhorn"></i> Social Media</dt>
                <dd>
                    <ul>
                        <?php // showSocialMedia(); ?>
                    </ul>
                </dd>
            </dl>
        </div>

        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="fas fa-sitemap"></i> Uniqe Users</dt>
               
                
                <dd><ul><?php echo showTenantsUniqueUsers(); ?></ul></dd>

            </dl>
        </div>

        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="fas fa-sitemap"></i> Downloads all time</dt>
                <dd><ul><?php echo showTenantsDownloadsLastDays(5000); ?></ul></dd>
            </dl>
        </div>

        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="fas fa-sitemap"></i> Downloads last 7 days</dt>

                <dd><ul><?php echo showTenantsDownloadsLastDays(7); ?></ul></dd>

            </dl>
        </div>
        <div class="col-6 col-md-6 col-lg-3 d-none">
            <dl>
                <dt><i class="fab fa-chrome"></i> Browser</dt>
                <dd><ul><?php //echo showBrowsers(); ?></ul></dd>

                Different User Agents
                <dd><?php //echo getUserAgentCount(); ?></dd>
            </dl>
        </div>
        <div class="col-6 col-md-6 col-lg-3 d-none">
            <dl>
                <dt><i class="fas fa-qrcode"></i> QR-Code</dt>
                <dd>QR-Code-Nutzungen: <?php //echo getQRCodeCount(); ?></dd>
            </dl>
            <dl>
                <dt><i class="fas fa-envelope"></i> E-Mail</dt>
                <dd>E-Mail-Versand: <?php //echo getEmailsCount(); ?></dd>
            </dl>
            <dl>
                <dt><i class="fas fa-save"></i> Arbeitsdateien</dt>
                <dd>Arbeitsdatei-Nutzungen: <?php // echo getSaveWorkCount(); ?></dd>
            </dl>
        
        </div>
     
    </div>
</div>
</body>
</html>
