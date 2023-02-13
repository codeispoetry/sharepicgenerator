<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/upload_functions.php'));
require_once(getBasePath('lib/user_functions.php'));
$file = sprintf('%s/%s', getBasePath('tmp'), sanitizeUserinput($_GET['f']));

// $db = new SQLite3(getBasePath('log/logs/log.db'));
// if (isAdmin()) {
//     $db->exec('CREATE TABLE IF NOT EXISTS qrcode(
//             id INTEGER PRIMARY KEY AUTOINCREMENT, 
//             timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
//             url TEXT)');
// }

// $smt = $db->prepare('INSERT INTO qrcode (url) values (:file)');
// $smt->bindValue(':url', $file, SQLITE3_TEXT);
// $smt->execute();

header('Content-Type: image/png');
header("Content-Length: ".filesize($file));
header('Content-Disposition: attachment; filename="sharepic.png"');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
readfile($file);
