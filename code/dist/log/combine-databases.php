<?php
die("Nein, die()-Sperre aktiviert");

require_once('base.php');
$start = time();

set_time_limit(3000);

setlocale(LC_TIME, ' de_DE.UTF-8', 'de_DE.utf8');

// get wanted col-names
$new = new SQLite3(getBasePath('log/logs/log.db'));
$results = $new->query("PRAGMA table_info('downloads');");
$columns = [];
while ($row = $results->fetchArray()) {
    if ($row['name'] === 'id') {
        continue;
    }
    $columns[] = $row['name'];
}
$stmt = $new->prepare(
    sprintf(
        'INSERT INTO downloads (%s) values (:%s)',
        join(',', $columns),
        join(',:', $columns)
    )
);

// get Data
//$old = new SQLite3(getBasePath('log/logs/logUNTIL-btw21.db'));
$old = new SQLite3(getBasePath('log/logs/log-btw21until2022-04-12.db'));

$results = $old->query("SELECT * FROM downloads LIMIT 500000 OFFSET 0");
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    insert($stmt, $columns, $row);
}

printf("Duration: %s", time() - $start);


// do logging into download
function insert($stmt, $columns, $data)
{
    foreach ($data as $variable => $value) {
        $stmt->bindValue(':'.$variable, $value, SQLITE3_TEXT);
    }
    $stmt->execute();
}
