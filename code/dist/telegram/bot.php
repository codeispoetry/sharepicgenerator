<?php
require_once('base.php');
require_once(getBasePath('lib/telegram_functions.php'));

/*
 * https://api.telegram.org/BOT_TOKEN/setWebhook?url=https://sharepicgenerator.de/bayern/telegram/bot.php
 * https://api.telegram.org/BOT_TOKEN/getWebhookInfo
 * https://api.telegram.org/BOT_TOKEN/deleteWebhook
 */
$configFile = getBasePath('/ini/config.ini');
if (file_exists($configFile)) {
    $keys = parse_ini_file($configFile, true);

    $botID = $keys["Telegram"]["botID"];

    handleRequest();
}
