<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
$file = sprintf('%s/%s.jpg', getBasePath('tmp'), sanitizeUserinput($_GET['f']));

if (isAdmin()) {
    $db->exec('CREATE TABLE IF NOT EXISTS qrcode(
            id INTEGER PRIMARY KEY AUTOINCREMENT, 
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
            url TEXT)');
}

$smt = $db->prepare('INSERT INTO qrcode (url) values (:file)');
$smt->bindValue(':url', $file, SQLITE3_TEXT);
$smt->execute();


header('Content-Type: image/jpg');
header("Content-Length: ".filesize($file));
header('Content-Disposition: attachment; filename="sharepic.jpg"');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
readfile($file);
