<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));

$db = new SQLite3(getBasePath('log/logs/log.db'));
if (isAdmin()) {
    $db->exec('CREATE TABLE IF NOT EXISTS searches(
        id INTEGER PRIMARY KEY AUTOINCREMENT, 
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        query TEXT,
        carrier TEXT)');
}


// do logging into searches

$smt = $db->prepare(
    'INSERT INTO searches (query,carrier) values (:query,:carrier)'
);
$smt->bindValue(':query', $_POST['q'], SQLITE3_TEXT);
$smt->bindValue(':carrier', $_POST['carrier'], SQLITE3_TEXT);

$smt->execute();

echo "ok";
