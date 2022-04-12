<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/log_functions.php'));

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

// get Data
//$old = new SQLite3(getBasePath('log/logs/logUNTIL-btw21.db'));
$old = new SQLite3(getBasePath('log/logs/log-btw21until2022-04-12.db'));

$results = $old->query("SELECT * FROM downloads");
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    insert($new, $columns, $row);
}


    // do logging into download
function insert($db, $columns, $data)
{
    $smt = $db->prepare(
        sprintf(
            'INSERT INTO downloads (%s) values (:%s)',
            join(',', $columns),
            join(',:', $columns)
        )
    );

    foreach ($data as $variable => $value) {
        $smt->bindValue(':'.$variable, $value, SQLITE3_TEXT);
    }
    $smt->execute();
}
