<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/mail_functions.php'));
useDeLocale();

session_start();

if (!isAllowed()) {
    die();
}

$file = getBasePath('tmp/' . sanitizeUserinput($_POST['file']));
$recipient = $_POST['recipient'];
$text = $_POST['text'];

$db = new SQLite3(getBasePath('log/logs/log.db'));
if (isAdmin()) {
    $db->exec('CREATE TABLE IF NOT EXISTS mail(
            id INTEGER PRIMARY KEY AUTOINCREMENT, 
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
            user TEXT,
            recipient TEXT)');
}

$smt = $db->prepare('INSERT INTO mail (user,recipient) values (:user, :recipient)');
$smt->bindValue(':user', getUser(), SQLITE3_TEXT);
$smt->bindValue(':recipient', $recipient, SQLITE3_TEXT);

$smt->execute();

email($recipient, $file, $text);
