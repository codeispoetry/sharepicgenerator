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

function show_images($dir)
{
    $files = array_reverse(glob($dir), GLOB_NOSORT);

    array_multisort(array_map('filemtime', $files), SORT_NUMERIC, SORT_DESC, $files);

    foreach ($files as $file) {
        list($id, $user, $time, $tags ) = explode('_', $file);
        printf(
            '<div class="col-6 col-md-3 col-lg-2">
                <figure>
                    <a href="%1$s"><img src="%1$s" class="img-fluid"/></a>
                    <figcaption>%2$s, %3$s</figcaption>
            </div>',
            $file,
            $user,
            str_replace('|', ' ', $tags)
        );
    }
}

function deleteFilesInPathOlderThanHours($hours, $path)
{
    $files = glob($path);
    $now = time();
    $counter = 0;

    foreach ($files as $file) {
        if (is_file($file) and $now - filemtime($file) >= 60 * 60 * $hours) {
            $counter++;
            unlink($file);
        }
    }

    printf('%d Dateien gelöscht ', $counter);
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

function echoResults($sql)
{
    global $db;
    $results = $db->query($sql);
    while ($row = $results->fetchArray()) {
        printf(
            '<li>%s: %s</li>',
            ($row['name']) ?: 'ohne',
            $row['count']
        );
    }
}

function getMedianSQLQuery($column, $percent = 50, $table = 'downloads')
{
    return sprintf(
        'SELECT %1$s AS result
        FROM %2$s
        WHERE %1$s > 0
        ORDER BY %1$s
        LIMIT 1
        OFFSET ROUND( (SELECT COUNT(*) FROM %2$s WHERE %1$s > 0) * %3$f)',
        $column,
        $table,
        $percent / 100
    );
}

function getUsers()
{
    return singleResult('SELECT COUNT(DISTINCT user) AS result FROM downloads;');
}

function getDownloads()
{
    return singleResult('SELECT COUNT(*) AS result FROM downloads;');
}

function getDailyDownloads()
{
    return singleResult("select avg(perDay) as result from (select count(*) as perDay from downloads WHERE date(timestamp) != date('now') GROUP BY date(timestamp) LIMIT -1 OFFSET 1);");
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

function showSocialMedia()
{
    return echoResults("select SUBSTR(socialmediaplatform,0,INSTR(socialmediaplatform,'-')) As name,count(*) as count from downloads GROUP BY name ORDER BY count DESC;");
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
    return echoResults("select backgroundsource As name,count(*) as count from downloads GROUP BY backgroundsource ORDER BY count DESC;");
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
    return round(singleResult("select avg(createTime) as result from downloads where createTime>0"));
}

function getMedianUploadTime($percent = 50)
{
    return singleResult(getMedianSQLQuery('uploadTime'), $percent);
}

function getAvgUploadTime()
{
    return round(singleResult("select avg(uploadTime) as result from downloads WHERE uploadTime>0"));
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
                    'Sachsen','Sachen-Anhalt','Schleswig-Holstein','Thürigen');

  
}

function showTenants()
{
    return echoResults("select tenant As name,count(*) as count from downloads GROUP BY tenant;");
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
