<?php

require_once('base.php');
require_once('lib/telegram_functions.php');

$configFile = getBasePath('/ini/config.ini');
if (file_exists($configFile)) {
    $keys = parse_ini_file('ini/config.ini', true);

    $botID = $keys["Telegram"]["botID"];
    $chatID = $keys["Telegram"]["channelID"];

    sendFile('tmp/' . $filename . '.' . $format);
}
