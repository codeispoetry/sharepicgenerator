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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
</head>
<body style="background:white">
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center">
            <h2>Statistiken</h2>
        </div>
        <div class="col-12 text-center mb-3">
            <a href="show.php" class="btn btn-primary btn-sm"><i class="fas fa-images"></i> Zeige die jüngsten Sharepics</a>
            <a href="logs/ai.log" class="btn btn-primary btn-sm"><i class="fas fa-images"></i> AI-Log</a>

        </div>
        <div class="col-12">
            <h4>Systemgesundheit</h4>
            Uhrzeit: <?php echo date('l, m.d, h:i \U\h\r'); ?><br>
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
                    täglich in den letzten 30 Tagen: <?php echo number_format(getDailyUsersLastDays(30), 0, ',', '.'); ?>
                        <br>
                    letzten 30 Tage: <?php echo number_format(getUsersLastDays(30), 0, ',', '.'); ?>
                        <br>
                    User (1 Login, 30 Tage): <?php echo number_format(getLoginCountsPerUserLastDays('=', 1, 30), 0, ',', '.'); ?>
                        <br>
                    User(>=4 Logins, 30 Tage): <?php echo number_format(getLoginCountsPerUserLastDays('>=', 4, 30), 0, ',', '.'); ?>
                        <br>
                    Logzeit seit ca.<?php echo number_format(getLoggingPeriodInDays()/30, 0, ',', '.'); ?> Monaten
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
                    täglich (in letzten 30 Tagen): <?php echo number_format(getDailyDownloadsLastDays(30), 0, ',', '.'); ?>
                    <br>
                    heute: <?php echo number_format(getDownloadsToday(), 0, ',', '.'); ?>
            </dl>
        </div>
         <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="far fa-clock"></i> Zeiten der letzten 7 Tage</dt>
                <dd>
                    Median Uploadtime: <?php echo round(getMedianUploadTime()/1000, 1); ?>s<br>
                    90% Uploadtime: <?php echo round(getMedianUploadTime(90)/1000, 1); ?>s
                </dd>
                <dd>
                    Median Createtime: <?php echo round(getMedianCreatingTime()/1000, 1); ?>s<br>
                    90% Createtime: <?php echo round(getMedianCreatingTime(90)/1000, 1); ?>s
                </dd>
                <dd>
                    Median Edittime: <?php echo round(getMedianEditTime()/60, 1); ?>min<br>
                    90% Edittime: <?php echo round(getMedianEditTime(90)/60, 1); ?>min<br>
                    Max Edittime: <?php echo round(getMaxEditTime()/60, 1); ?>min
                </dd>
            </dl>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="far fa-images"></i> Suchbegriffe der letzten 7 Tage</dt>
                <dd>
                    <ul>
                        <?php getSearchTerms(7); ?>
                    </ul>
                </dd>
            </dl>
        </div>

        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="far fa-images"></i> Hauptbegriffe der letzten <?php $days = 30; echo $days;?> Tage</dt>
                <dd>
                    <ul>
                        <?php
                            $wordCounts = wordCounts([
                                'days' => $days,
                                'strlen' => 5,
                                'mincount' => 10,
                                'limit' => 15,
                            ]);
                            foreach($wordCounts AS $word => $count){
                                printf('<li>%s (%d)</li>', $word, $count);
                            }

                        ?>
                    </ul>
                </dd>
            </dl>
        </div>

        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="fas fa-bullhorn"></i> Social Media letzten 7 Tage</dt>
                <dd>
                    <ul>
                        <?php showSocialMedia(7); ?>
                    </ul>
                </dd>
            </dl>
        </div>

        <div class="col-6 col-md-6 col-lg-3">
            <dl>
                <dt><i class="fas fa-sitemap"></i> Downloads letzten 7 Tage</dt>

                <dd><ul><?php echo showTenantsDownloadsLastDays(7); ?></ul></dd>

            </dl>
        </div>
     
    </div>
</div>
</body>
</html>
