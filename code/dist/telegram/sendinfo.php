<?php

require_once('lib/telegram_functions.php');

if (file_exists('ini/config.ini')) {
    $keys = parse_ini_file('ini/config.ini', true);

    $botID = $keys["Telegram"]["botID"];
    $chatID = $keys["Telegram"]["channelID"];

    sendFile('tmp/' . $filename . '.' . $format);
}
