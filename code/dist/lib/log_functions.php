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

function echoResultsForChartJS($sql)
{
    static $i;
    $i = (!$i) ? 1 : $i +1;

    global $db;
    $results = $db->query($sql);
    $labels = array();
    $values = array();
    while ($row = $results->fetchArray()) {
        $values[] = $row['count'];
        $labels[] = "'".$row['name']."'";
    }
    $labels = join(',', $labels);
    $values = join(',', $values);


    echo <<<CHARTJS
        <div><canvas id="chart{$i}" height="300"></canvas></div>

        <script>
  
  const data{$i} = {
    labels: [$labels],
    datasets: [{
      backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(255, 205, 86)',
        'rgb(55, 99, 132)',
        'rgb(254, 162, 235)',
        'rgb(55, 205, 86)',
        'rgb(254, 62, 235)',
        'rgb(55, 5, 86)'
        ],
      borderColor: 'rgb(255, 99, 132)',
      data: [$values],
    }]
  };

  const config{$i} = {
    type: 'pie',
    data: data{$i},
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins:{
          legend: {
            display: false
            },
        },
    }
  };

   const myChart{$i} = new Chart(
    document.getElementById('chart{$i}'),
    config{$i}
  );
</script>

CHARTJS;
}

function echoResults($sql, $inPercent = false)
{
    global $db;
    $results = $db->query($sql);
    while ($row = $results->fetchArray()) {
        if ($inPercent) {
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
        OFFSET ROUND( (SELECT COUNT(*) FROM %2$s WHERE %1$s > 0 AND julianday("now") - julianday(timestamp) < %4$s) * %3$f) - 1',
        $column,
        $table,
        $percent / 100,
        $last
    );
}

function getUsers()
{
    return singleResult('SELECT COUNT(DISTINCT user) AS result FROM downloads;');
}

function getUsersLastDays($days = 7)
{
    return singleResult(
        'SELECT COUNT(DISTINCT user) AS result FROM downloads 
      WHERE julianday("now") - julianday(timestamp) < ' . $days . ';'
    );
}

function getUsersActivity($percent = 50)
{
    return singleResult(
        'select count(*) as result from downloads GROUP BY user ORDER BY result LIMIT 1 
    OFFSET ROUND((SELECT COUNT(DISTINCT user) from downloads) * ' . $percent/100 . ');'
    );
}

function getLoginCountsPerUserLastDays($operator = '=', $threshold = 1, $days = 30)
{
    return singleResult(
        'select count(*) as result from (
        select count(distinct timestamp) as result from downloads where julianday("now") - julianday(timestamp) <= ' . $days .' GROUP BY user HAVING result ' . $operator . $threshold . ')'
    );
}

function getDownloadsLastDay($days = 0)
{
    return singleResult("SELECT COUNT(*) AS result FROM downloads WHERE date(timestamp) = date('now', '-{$days} days');");
}

function getDownloads()
{
    static $total;
    if (!$total) {
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

function getDailyDownloadsLastDays($days = 30)
{
    return singleResult("select cast(avg(perDay) as int) as result from (select count(*) as perDay from downloads WHERE julianday('now') - julianday(timestamp) <= $days AND date(timestamp) != date('now') GROUP BY date(timestamp) LIMIT -1 OFFSET 1);");
}

function getPixabay()
{
    return singleResult("select count(*) as result from downloads WHERE backgroundSource='pixabay';");
}



function showSocialMedia($days = 7)
{
    return echoResultsForChartJS("select SUBSTR(socialmedia,0,INSTR(socialmedia,'-')) AS name,count(*) AS count FROM downloads WHERE julianday('now') - julianday(timestamp) <= $days AND socialmedia IS NOT NULL GROUP BY name ORDER BY count DESC;");
}



function getSocialMedia()
{
    return singleResult("select count(*) as result from downloads WHERE socialmedia !=''");
}


function getMedianCreatingTime($percent = 50)
{
    return singleResult(getMedianSQLQuery('createTime', $percent));
}

function getMedianEditTime($percent = 50)
{
    return singleResult(getMedianSQLQuery('editTime', $percent));
}

function getMaxEditTime()
{
    return round(singleResult('select max(editTime) as result from downloads where createTime>0 AND cast(julianday("now") - julianday(timestamp) as int) < 7'));
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
    return echoResults("select tenant As name,count(distinct user) as count from downloads GROUP BY tenant ORDER BY count DESC;");
}

function showTenantsDownloadsLastDays($days = 7)
{
    return echoResultsForChartJS("select tenant As name,count(*) as count from downloads WHERE julianday('now') - julianday(timestamp) <= $days GROUP BY tenant ORDER BY count DESC;");
}

function getDailyUsersLastDays($days = 30)
{
    return singleResult("select avg(userPerDay) as result from (select count(DISTINCT user) as userPerDay from downloads WHERE  julianday('now') - julianday(timestamp) <= $days AND date(timestamp) != date('now') GROUP BY date(timestamp) LIMIT -1 OFFSET 1);");
}


function getFreeSpace()
{
    $cmd = "df -h / | tail -n +2 |  awk '{ print $4 }'";
    exec($cmd, $output);

    return $output[0];
}

function getSearchTerms($days = 7)
{
    $sql = sprintf(
        "SELECT 
            lower(query) AS name, COUNT(*) AS count
        FROM 'searches' 
        WHERE
            timestamp >= date('now', '-%d day')
        GROUP BY lower(query) 
        HAVING 
            count(*) > 10 
        ORDER BY 
            COUNT(*) 
        DESC
        LIMIT 
            10",
        $days
    );
    return echoResults($sql);
}


function allWords($days = 7)
{
    $sql = sprintf(
        "SELECT 
            lower(text) AS word
        FROM 'downloads' 
        WHERE
            timestamp >= date('now', '-%d day')",
        $days
    );


    global $db;
    $results = $db->query($sql);
    while ($row = $results->fetchArray()) {
       echo $row['word'] . ' ';
    }
}

function wordCounts($days = 7)
{
    global $db;
    $sql = sprintf(
        "SELECT 
            lower(text) AS word
        FROM 'downloads' 
        WHERE
            timestamp >= date('now', '-%d day')",
        $days
    );

    $ignoreWords = explode(',', 'der,die,das,mit,und,für,den,auf,vom,ihre,zum,uhr,
 innen,aus,auch,daher,ein,eine,von,des,eines,the,dem,bzw,zur,ist,ihr,werden,seid,innen,einen,als' );
    $wordCounts = [];
    $results = $db->query($sql);
    while ($row = $results->fetchArray()) {
        $words = preg_split('/\b/u', $row['word']);

        foreach($words AS $word) {
            $word = trim($word);

            if(strlen($word) <= 3) {
               continue;
            }

            if(in_array($word, $ignoreWords)) {
                continue;
            }


            (isset($wordCounts[$word])) ? $wordCounts[$word]++ : $wordCounts[$word] = 1;
        }
    }

    $wordCounts = array_filter($wordCounts, function($val){
        return $val > 20;
    });

    arsort($wordCounts);
    return $wordCounts;
}

function showLogGraph()
{
    global $db;
    // by day
    $sql = "SELECT strftime('%d.%m.', timestamp) AS period, COUNT(*) AS count, strftime('%d.%m', timestamp) AS bar, strftime('%w', timestamp) AS weekday FROM downloads GROUP BY strftime('%d.%m.', timestamp) ORDER BY timestamp;";
    // by week
    $sql = "SELECT strftime('%Y%W', timestamp) AS period, COUNT(*) AS count, strftime('%d.%m.', timestamp) AS description FROM downloads GROUP BY period ORDER BY period;";
    // by month
    $sql = "SELECT strftime('%Y%m', timestamp) AS period, COUNT(*) AS count, strftime('%m/%Y', timestamp) AS description FROM downloads GROUP BY period ORDER BY period;";
    $results = $db->query($sql);

    $values = [];
    $labels = [];
    while ($row = $results->fetchArray()) {
          $values[] = $row['count'];
          $labels[] = $row['description'];
    }
    $values = join(',', $values);
    $labels = "'" . join("','", $labels) . "'";


    echo <<<ECHO
        <div><canvas id="chart" height="300"></canvas></div>

        <script>
  
  const data = {
    labels: [$labels],
    datasets: [{
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [$values],
    }]
  };

  const config = {
    type: 'line',
    data: data,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins:{
          legend: {
            display: false
            },
        },
    }
  };

   const myChart = new Chart(
    document.getElementById('chart'),
    config
  );
</script>

ECHO;
}
