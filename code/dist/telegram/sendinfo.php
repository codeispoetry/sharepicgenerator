<?php

if (file_exists('ini/config.ini')) {
    $keys = parse_ini_file('ini/config.ini', TRUE);

    $botID = $keys["Telegram"]["botID"];
    $chatID = $keys["Telegram"]["channelID"];

    sendFile('tmp/' . $filename . '.' . $format);
}


function sendMessage($message)
{
    if (!$message) return;
    global $botID, $chatID;
    readfile('https://api.telegram.org/' . $botID . '/sendMessage?chat_id=' . $chatID . '&text=' . $message);
}

function sendFile($file)
{
    global $botID, $chatID;
    $botURL = "https://api.telegram.org/$botID/";
    $url = $botURL . "sendPhoto?chat_id=" . $chatID;

    $post_fields = array('chat_id' => $chatID,
        'photo' => new CURLFile(realpath($file)),
        'silent' => true
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type:multipart/form-data"
    ));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    $output = curl_exec($ch);
}