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
        list($foo, $user, $foo ) = explode('_', $file);
        printf(
            '<div class="col-6 col-md-3 col-lg-2">
                <figure>
                    <a href="%1$s"><img src="%1$s" class="img-fluid"/></a>
                    <figcaption>%2$s</figcaption>
            </div>',
            $file,
            $user
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
    return singleResult("select avg(perDay) as result from (select count(*) as perDay from downloads GROUP BY date(timestamp));");
}

function getPixabay()
{
    return singleResult("select count(*) as result from downloads WHERE ;");
}

function showSocialMedia()
{
    global $db;
    arsort($info['socialmedia']);
    foreach ($info['socialmedia'] as $platform => $counter) {
        printf('<li>%s: %d</li>', $platform, $counter);
    }
}

function getSocialMedia()
{
    global $db;
    return array_sum($info['socialmedia']);
}

function getTelegramUser()
{
    $telegram = glob('../api/user/*', GLOB_ONLYDIR);
    return count($telegram);
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
    return singleResult(
    "SELECT date('now') - date(timestamp) AS result FROM downloads ORDER BY timestamp DESC LIMIT 1;");
}

function showTimeline()
{
    global $db;

    $i = 0;
    foreach (array_reverse($info['logins']) as $day => $users) {
        printf('<li>%s: %d</li>', $day, count(array_unique($users)));
        $i++;

        if ($i == 7) {
            return;
        }
    }
}

function showHours()
{
    global $db;
    $totalUsers = 0 ;
    foreach ($info['hours'] as $hour => $users) {
        $totalUsers += count(array_unique($users));
    }

    ksort($info['hours']);

    $hours = array('0 bis 6', '6 bis 12', '12 bis 18', '18 bis 24');


    foreach ($info['hours'] as $hour => $users) {
        printf('<li>%s: %.1f%%</li>', $hours[ $hour ], 100*count(array_unique($users))/$totalUsers);
    }
}

function showWeekdays()
{
    global $db;

    ksort($info['weekdays']);
    $days = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');

    foreach ($info['weekdays'] as $weekday => $users) {
        printf('<li>%s: %d</li>', $days[$weekday], count(array_unique($users)));
    }
}

function showProvinces()
{
    global $db;
    $totalUsers = getUsers();

    ksort($info['provinces']);
    $provinces = array('offbyone','Baden-Württemberg', 'Bayern', 'Berlin', 'Brandenburg', 'Bremen', 'Hamburg', 'Hessen',
                        'Mecklenburg-Vorpommern','Niedersachsen','Nordrhein-Westfalen','Rheinland-Pfalz','Saarland',
                    'Sachsen','Sachen-Anhalt','Schleswig-Holstein','Thürigen');
    foreach ($info['provinces'] as $province => $users) {
        printf('<li>%s: %.1f%%</li>', $provinces[ $province ], 100*count(array_unique($users))/$totalUsers);
    }
}

function showTenants()
{
    global $db;

    foreach ($info['tenants'] as $tenant => $users) {
        printf('<li>%s: %s</li>', $tenant, number_format(count(array_unique($users)), 0, ',', '.'));
    }
}

function drawTimeline()
{
    global $db;

    $i = 0;
    echo array_keys($info['logins'])[0];
    foreach ($info['logins'] as $day => $users) {
        printf('<span class="graph" style="height:%dpx" title="%1$d am %2$s"></span>', count(array_unique($users)), $day);
    }
    echo end(array_keys($info['logins']));
}

function getAverageUserPerDay()
{
    return singleResult("select avg(userPerDay) as result from (select count(DISTINCT user) as userPerDay from downloads GROUP BY date(timestamp));");
}

function getUserWithSaving()
{
    exec('find ../persistent/user/ -name save.txt | wc -l', $output);
    return $output[0];
}

function getUserWithCustomLogo()
{
    exec('find ../persistent/user/ -name logo.png | wc -l', $output);
    return $output[0];
}
