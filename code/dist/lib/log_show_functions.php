<?php
$db = new SQLite3(getBasePath('log/logs/log.db'));

function singleResult($sql)
{
    global $db;
    $results = $db->query($sql);

    if (is_bool($results)) {
        return 0;
    }

    $row = $results->fetchArray();

    return $row['result'];
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
            '<li><a href="?tenant=%1$s">%1$s: %2$s%3$s</a></li>',
            ($row['name']) ?: 'ohne',
            $value,
            ($inPercent) ? '%' : ''
        );
    }
}

function show_dalle()
{
    global $db;
    $sql = 'SELECT * FROM downloads WHERE dalle != "" ORDER BY timestamp DESC LIMIT 10;';
    $results = $db->query($sql);

    echo '<ul>';
    while ($row = $results->fetchArray()) {
        printf('<li><a href="show_single_sharepic.php?id=%1$s">%2$s</a></li>', $row['sharepicid'], $row['dalle']);
    }
    echo '</ul>';
}

function getUsers()
{
    return singleResult('SELECT COUNT(DISTINCT user) AS result FROM downloads;');
}

function getSingleSharepic($id)
{
    global $db;
    $sql = 'SELECT * FROM downloads WHERE sharepicid = "' . preg_replace('/[^a-zA-Z0-9]/', '', $id) .'"';

    $results = $db->query($sql);
    $row = $results->fetchArray(SQLITE3_ASSOC);

    return $row;
}

function getUsersLastDays($days = 7)
{
    return singleResult(
        'SELECT COUNT(DISTINCT user) AS result FROM downloads 
      WHERE julianday("now") - julianday(timestamp) < ' . $days . ';'
    );
}

function getDownloads()
{
    static $total;
    if (!$total) {
        $total = singleResult('SELECT COUNT(*) AS result FROM downloads;');
    }

    return $total;
}

function getDownloadsByTenant($tenant)
{
    global $db;
    $sql = "SELECT * FROM downloads WHERE tenant = '{$tenant}' ORDER BY timestamp DESC LIMIT 100;";
    return $db->query($sql);
}


function getNumberOfDownloadsByTenant($tenant)
{
    return singleResult("SELECT COUNT(*) AS result FROM downloads WHERE tenant = '{$tenant}'");
}

function getNumberOfUsersByTenant($tenant)
{
    return singleResult("SELECT COUNT(DISTINCT user) AS result FROM downloads WHERE tenant = '{$tenant}'");
}

function getDailyDownloadsLastDays($days = 30)
{
    return singleResult("select cast(avg(perDay) as int) as result from (select count(*) as perDay from downloads WHERE julianday('now') - julianday(timestamp) <= $days AND date(timestamp) != date('now') GROUP BY date(timestamp) LIMIT -1 OFFSET 1);");
}

function getLoggingPeriodInDays()
{
    return singleResult("SELECT julianday('now') - julianday(timestamp) AS result FROM downloads ORDER BY timestamp ASC LIMIT 1;");
}

function getAI($type = 'used')
{
    return singleResult("SELECT COUNT(*) AS result FROM downloads WHERE ai = '{$type}';");
}

function showTenantsDownloads()
{
    return echoResults("select tenant As name,count(*) as count from downloads GROUP BY tenant HAVING count > 50 ORDER BY count DESC;");
}

function getFreeSpace()
{
    $cmd = "df -h / | tail -n +2 |  awk '{ print $4 }'";
    exec($cmd, $output);

    return $output[0];
}

function showLogGraph($tenant = false)
{
    global $db;

    $where = '';
    if ( $tenant ) {
        $where = " WHERE tenant = '{$tenant}' ";
    }
  
    // by day
    //$sql = "SELECT strftime('%d.%m.', timestamp) AS period, COUNT(*) AS count, strftime('%d.%m', timestamp) AS description, strftime('%w', timestamp) AS weekday FROM downloads $where GROUP BY strftime('%d.%m.', timestamp) ORDER BY timestamp;";
    // by week
    $sql = "SELECT strftime('%Y%W', timestamp) AS period, COUNT(*) AS count, strftime('%d.%m.', timestamp) AS description FROM downloads $where GROUP BY period ORDER BY period;";
    // by month
    //$sql = "SELECT strftime('%Y%m', timestamp) AS period, COUNT(*) AS count, strftime('%m/%Y', timestamp) AS description FROM downloads $where GROUP BY period ORDER BY period;";


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
      backgroundColor: 'rgb(20, 95, 50)',
      borderColor: 'rgb(160, 200, 100)',
      data: [$values],
    }]
  };

  const config = {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true
          }
        },
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
