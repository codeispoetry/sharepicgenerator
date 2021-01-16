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

    //printf('%d Dateien gelöscht ', $counter);
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
            number_format($row['count'], 0, ',', '.')
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

function getDownloads()
{
    return singleResult('SELECT COUNT(*) AS result FROM downloads;');
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
                    'Sachsen','Sachen-Anhalt','Schleswig-Holstein','Thürigen');

  
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
