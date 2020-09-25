<?php

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
    $files = array_reverse(glob($dir));

    foreach ($files as $file) {
        printf(
            '<div class="col-6 col-md-3 col-lg-2"><a href="showsource.php?file=%s&picture=%s"><img src="%s" class="img-fluid"/></a></div>',
            substr(preg_replace('/^(.*?)_/', '', $file), 0, -4),
            $file,
            $file
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

function readLogs()
{
    global $info;

    $lines = file('logs/log.log');

    $info = array(
        'socialmedia' => array()
    );

    foreach ($lines as $line) {
        list($time, $user, $action, $payload1, $payload2) = explode("\t", trim($line));

        if (floor(time()/86400) == floor($time/86400)) {
            // do not evaluate data from today
            // break;
        }

        $day =  date('l, d.m.', $time);
        $hour =  date('G', $time) / 6;
        $weekday =  date('w', $time);


        switch ($action) {
            case "login":
                $info['logins'][ $day ][] =  $user;
                $info['users'][] = $user;
                $info['hours'][ $hour ][] = $user;
                $info['weekdays'][ $weekday ][] = $user;
                $info['provinces'][ $payload1 ][] = $user;
                $info['tenants'][ $payload2 ][] = $user;

                break;
            case "download":
                $info['downloads']++;
                if ($payload1) {
                    $info['pixabay']++;
                }
                if ($payload2) {
                    // by Platform and subtitle
                    // $info['socialmedia'][ $payload2 ] = $info['socialmedia'][ $payload2 ] + 1 ?: 1;
                    // by Platform
                    $platform = preg_replace("/(.(.*?))[A-Z](.*)$/", "$1", $payload2);
                    $info['socialmedia'][ $platform ] = $info['socialmedia'][ $platform ] + 1 ?: 1;
                }
                break;

            default:
                echo("error for line: " . $line);
        }
    }
}

function getUsers()
{
    global $info;
    return count(array_unique($info['users']));
}

function getDownloads()
{
    global $info;
    return $info['downloads'];
}

function getDailyDownloads()
{
    global $info;
    return $info['downloads'] / getLoggingPeriodInDays();
}

function getPixabay()
{
    global $info;
    return $info['pixabay'];
}

function showSocialMedia()
{
    global $info;
    arsort($info['socialmedia']);
    foreach ($info['socialmedia'] as $platform => $counter) {
        printf('<li>%s: %d</li>', $platform, $counter);
    }
}

function getSocialMedia()
{
    global $info;
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
    global $info;
    return count($info['logins']);
}

function showTimeline()
{
    global $info;

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
    global $info;
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
    global $info;

    ksort($info['weekdays']);
    $days = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');

    foreach ($info['weekdays'] as $weekday => $users) {
        printf('<li>%s: %d</li>', $days[$weekday], count(array_unique($users)));
    }
}

function showProvinces()
{
    global $info;
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
    global $info;

    foreach ($info['tenants'] as $tenant => $users) {
        printf('<li>%s: %s</li>', $tenant, number_format(count(array_unique($users)), 0, ',', '.'));
    }
}

function drawTimeline()
{
    global $info;

    $i = 0;
    echo array_keys($info['logins'])[0];
    foreach ($info['logins'] as $day => $users) {
        printf('<span class="graph" style="height:%dpx" title="%1$d am %2$s"></span>', count(array_unique($users)), $day);
    }
    echo end(array_keys($info['logins']));
}

function getAverageUserPerDay()
{
    global $info;

    $days = array();

    foreach ($info['logins'] as $day => $users) {
        $days[ $day ] = count(array_unique($users));
    }

    return array_sum($days) / count($days);
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
