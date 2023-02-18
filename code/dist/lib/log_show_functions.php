<?php
$db = new SQLite3(getBasePath('log/logs/log.db'));

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
    return echoResults("select tenant As name,count(*) as count from downloads GROUP BY tenant;");
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
