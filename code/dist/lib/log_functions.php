<?php
$db = new SQLite3(getBasePath('log/logs/log.db'));

function show_videos($dir)
{
    $files = array_reverse(glob($dir));

    echo '<ol>';
    foreach ($files as $file) {
        printf('<li><a href="%s"/>%s</a></li>', $file, date("d. F Y, H:i", filemtime($file)));
    }
    echo '</ol>';
}

function show_images($dir, $showCaption = false)
{
    $files = array_reverse(glob($dir), GLOB_NOSORT);

    array_multisort(array_map('filemtime', $files), SORT_NUMERIC, SORT_DESC, $files);

    foreach ($files as $file) {
        list($foo, $tenant, $user, $id ) = explode('_', $file);
        $caption = '';
        if ($showCaption) {
            $caption = $user;
        }
        printf(
            '<div class="col-6 col-md-3 col-lg-2">
                <figure>
                    <a href="%1$s"><img src="%1$s" class="img-fluid"/></a>
                    <figcaption>%2$s</figcaption>
            </div>',
            $file,
            $caption
        );
    }
}

function deleteFilesInPathOlderThanHours($path, $exclude, $hours)
{
    $cmd = sprintf('find %s ! -name "%s" -mmin +%d -exec rm -r {} \;', $path, $exclude, $hours * 60);
    exec($cmd, $output);  
}

function showCustomLogos()
{
    exec('find ../persistent/user/ -name logo.png', $output);
    foreach ($output as $file) {
        printf('<div class="col-2"><img src="%s" class="img-fluid"></div>', $file);
    }
}

function singleResult($sql)
{
    global $db;
    $results = $db->query($sql);
    $row = $results->fetchArray();

    return $row['result'];
}

function echoResults($sql, $inPercent = false)
{
    global $db;
    $results = $db->query($sql);
    while ($row = $results->fetchArray()) {
        

        if( $inPercent ){
            $fraction = $row['count'] / getDownloads();
            $decimal_places = ($fraction > 0.01) ? 2 : 4;
            $value = 100 * round($fraction, $decimal_places);
        } else {
            $value = number_format($row['count'], 0, ',', '.');
        }

        printf(
            '<li>%s: %s%s</li>',
            ($row['name']) ?: 'ohne',
            $value,
            ($inPercent) ? '%' : ''
        );
    }
}

function getMedianSQLQuery($column, $percent = 50, $table = 'downloads', $last = 7)
{
    return sprintf(
        'SELECT %1$s AS result
        FROM %2$s
        WHERE %1$s > 0 AND julianday("now") - julianday(timestamp) < %4$s
        ORDER BY %1$s
        LIMIT 1
        OFFSET ROUND( (SELECT COUNT(*) FROM %2$s WHERE %1$s > 0 AND julianday("now") - julianday(timestamp) < %4$s) * %3$f)',
        $column,
        $table,
        $percent / 100,
        $last
    );
    die();
}

function getUsers()
{
    return singleResult('SELECT COUNT(DISTINCT user) AS result FROM downloads;');
}

function getUsersLastDays($days = 7)
{
    return singleResult('SELECT COUNT(DISTINCT user) AS result FROM downloads 
      WHERE julianday("now") - julianday(timestamp) < ' . $days . ';');
}

function getUsersActivity($percent = 50)
{
    return singleResult('select count(*) as result from downloads GROUP BY user ORDER BY result LIMIT 1 
    OFFSET ROUND((SELECT COUNT(DISTINCT user) from downloads) * ' . $percent/100 . ');');
}

function getLoginCountsPerUserLastDays($operator = '=', $threshold = 1, $days = 30)
{
    return singleResult('select count(*) as result from (
        select count(distinct timestamp) as result from downloads where julianday("now") - julianday(timestamp) <= ' . $days .' GROUP BY user HAVING result ' . $operator . $threshold . ')');
}

function getDownloadsLastDay($days = 0)
{
    return singleResult("SELECT COUNT(*) AS result FROM downloads WHERE date(timestamp) = date('now', '-{$days} days');");
}

function getDownloads()
{
    static $total;
    if(!$total){
        $total = singleResult('SELECT COUNT(*) AS result FROM downloads;');
    }

    return $total;
}

function getUniqueDownloads()
{
    global $db;
    $results = $db->query('SELECT COUNT(DISTINCT backgroundURL) AS result FROM downloads');
    $row = $results->fetchArray();
    $customBackgroundURL =  $row['result'];

    $results = $db->query('select count(distinct text) AS result from downloads where backgroundURL like "/assets/%";');
    $row = $results->fetchArray();
    $textOnly =  $row['result'];

    return $customBackgroundURL + $textOnly;
}

function getDailyDownloads()
{
    return singleResult("select cast(avg(perDay) as int) as result from (select count(*) as perDay from downloads WHERE date(timestamp) != date('now') GROUP BY date(timestamp) LIMIT -1 OFFSET 1);");
}

function getPixabay()
{
    return singleResult("select count(*) as result from downloads WHERE backgroundSource='pixabay';");
}

function getWithEyecatcher()
{
    return singleResult("select count(*) as result from downloads WHERE pintext !='';");
}

function getAddText()
{
    return singleResult("select count(*) as result from downloads WHERE addtext !='';");
}

function getEraser()
{
    return singleResult("select count(*) as result from downloads WHERE eraser !='';");
}

function getAddPic()
{
    return singleResult("select count(*) as result from downloads WHERE addpicfile1 !='' OR addpicfile2 != '';");
}

function getGreenifyRelative()
{
    $greenified = singleResult("select count(*) as result from downloads WHERE greenified = 1");
    $total = $greenified + singleResult("select count(*) as result from downloads WHERE greenified = 0");
    return $greenified / $total;
}

function showSocialMedia()
{
    return echoResults("select SUBSTR(socialmediaplatform,0,INSTR(socialmediaplatform,'-')) As name,count(*) as count from downloads GROUP BY name ORDER BY count DESC;", true);
}

function showFaces()
{
    return echoResults("select faces As name,count(*) as count from downloads GROUP BY faces ORDER BY count DESC;");
}

function showLogos()
{
    return echoResults("select logoselect As name,count(*) as count from downloads GROUP BY logoselect ORDER BY count DESC;");
}

function showLayouts()
{
    return echoResults("select layout As name,count(*) as count from downloads WHERE tenant='federal' GROUP BY layout ORDER BY count DESC;");
}

function showBackgroundSources()
{
    return echoResults("select backgroundsource As name,count(*) as count from downloads GROUP BY backgroundsource ORDER BY count DESC;", true);
}

function showPixabaySearchesAllTime()
{
    return echoResults("select query As name,count(*) as count from searches GROUP BY query ORDER BY count DESC LIMIT 7;");
}

function showPixabaySearchesLastDays($days = 7)
{
    return echoResults("select query As name,count(*) as count from searches WHERE julianday('now') - julianday(timestamp) <= $days GROUP BY query ORDER BY count DESC LIMIT 7;");
}

function getSocialMedia()
{
    return singleResult("select count(*) as result from downloads WHERE socialmediaplatform !=''");
}

function getTelegramUser()
{
    $telegram = glob('../api/user/*', GLOB_ONLYDIR);
    return count($telegram);
}

function getMedianCreatingTime($percent = 50)
{
    return singleResult(getMedianSQLQuery('createTime', $percent));
}

function getAvgCreatingTime()
{
    return round(singleResult('select avg(createTime) as result from downloads where createTime>0 AND cast(julianday("now") - julianday(timestamp) as int) < 7'));
}

function getMedianUploadTime($percent = 50)
{
    return singleResult(getMedianSQLQuery('uploadTime', $percent));
}

function getAvgUploadTime()
{
    return round(singleResult('select avg(uploadTime) as result from downloads WHERE uploadTime>0 AND cast(julianday("now") - julianday(timestamp) as int) < 7'));
}

function showTelegramPics()
{
    $telegram = glob('../api/user/*', GLOB_ONLYDIR);
    foreach ($telegram as $dir) {
        printf('<div class="col-2"><img src="%s/sharepic.jpg" class="img-fluid"></div>', $dir);
    }
}

function getLoggingPeriodInDays()
{
    return singleResult("SELECT julianday('now') - julianday(timestamp) AS result FROM downloads ORDER BY timestamp ASC LIMIT 1;");
}

function showProvinces()
{

    $provinces = array('offbyone','Baden-Württemberg', 'Bayern', 'Berlin', 'Brandenburg', 'Bremen', 'Hamburg', 'Hessen',
                        'Mecklenburg-Vorpommern','Niedersachsen','Nordrhein-Westfalen','Rheinland-Pfalz','Saarland',
                    'Sachsen','Sachsen-Anhalt','Schleswig-Holstein','Thürigen');

  
}

function showTenantsDownloads()
{
    return echoResults("select tenant As name,count(*) as count from downloads GROUP BY tenant;");
}

function showTenantsUniqueUsers()
{
    return echoResults("select tenant As name,count(distinct user) as count from downloads GROUP BY tenant;");
}

function showTenantsDownloadsLastDays( $days = 7)
{
    return echoResults("select tenant As name,count(*) as count from downloads WHERE julianday('now') - julianday(timestamp) <= $days GROUP BY tenant;");
}

function showBrowsers()
{
    return echoResults("select browser As name,count(*) as count from downloads GROUP BY browser;");
}

function getUserAgentCount(){
    return singleResult('select count(distinct useragent) as result from downloads;');
}

function getDailyUsers()
{
    return singleResult("select avg(userPerDay) as result from (select count(DISTINCT user) as userPerDay from downloads WHERE date(timestamp) != date('now') GROUP BY date(timestamp) LIMIT -1 OFFSET 1);");
}

function getUserWithCustomLogo()
{
    exec('find ../persistent/user/ -name logo.png | wc -l', $output);
    return $output[0];
}

function getQRCodeCount()
{
    return singleResult("select count(*) as result from qrcode;");
}

function getSaveWorkCount()
{
    return singleResult("select count(*) as result from downloads where useSaveWork = 1;");
}

function getEmailsCount()
{
    return singleResult("select count(*) as result from mail;");
}

function getImageBlackWhite()
{
    return singleResult("select count(*) as result from downloads where graybackground != 1") / getDownloads();
}

function getImageBlur()
{
    return singleResult("select count(*) as result from downloads where blurbackground != 0") / getDownloads();
}

function getImageDarkLight()
{
    return singleResult("select count(*) as result from downloads where darklightlayer != 0") / getDownloads();
}

function getImageGreen()
{
    return singleResult("select count(*) as result from downloads where greenlayer != 0") / getDownloads();
}

function getFreeSpace()
{
    $cmd = "df -h / | tail -n +2 |  awk '{ print $4 }'";
    exec($cmd, $output);

    return $output[0];
}

function showLogGraph()
{
    global $db;
    // by day
    $sql = "SELECT strftime('%d.%m.', timestamp) AS period, COUNT(*) AS count, strftime('%d.%m', timestamp) AS bar, strftime('%w', timestamp) AS weekday FROM downloads GROUP BY period ORDER BY period;";
    // by week
    //$sql = "SELECT strftime('%Y%W', timestamp) AS period, COUNT(*) AS count, strftime('%m%Y', timestamp) AS bar FROM downloads GROUP BY period ORDER BY period;";
    // by month
    //$sql = "SELECT strftime('%Y%m', timestamp) AS period, COUNT(*) AS count, strftime('%m%Y', timestamp) AS bar FROM downloads GROUP BY period ORDER BY period;";
    $results = $db->query($sql);

    $style = <<<STYLE
        <style>
            .bar{
                width: 100%;
                background: #f06464;
                align-self:flex-end;
                justify-content:flex-start;
                flex-direction: column;
                align-items: center;
                display: flex;
                margin-left: 1px;
                max-width: 50px;
            }

            .bar small{
                font-size: 70%;
            }

            .weekend{
                background: #ffc2c2;
            }

            .spacer-left{
                margin-left: 20px;
            }
        </style>
STYLE;
    echo $style;
    echo '<div style="display:flex;">';

    $oldMonth = 0;
    while ($row = $results->fetchArray()) {
       printf('<div class="bar %5$s %1$s" style="height:%2$dpx" title="%4$s: %3$s">%3$s <small>%4$s</small></div>', 
        ($row['weekday'] == 1) ? 'spacer-left' : '', 
        $row['count'] / 10, 
        number_format($row['count'], 0, ',', '.'), 
        $row['period'],
        ($row['weekday'] == 0 || $row['weekday'] == 6) ? 'weekend' : 'weekday'
        );
    }
    echo "</div>";
}