<?php

/*
 * https://api.telegram.org/BOT_TOKEN/setWebhook?url=https://sharepicgenerator.de/bayern/telegram/bot.php
 * https://api.telegram.org/BOT_TOKEN/getWebhookInfo
 * https://api.telegram.org/BOT_TOKEN/deleteWebhook
 */
if (file_exists('../config.ini')) {
    $keys = parse_ini_file('../config.ini', TRUE);

    $botID = $keys["Telegram"]["botID"];

    handleRequest();
}


function handleRequest()
{
    global $botID, $chatID;
    $website = "https://api.telegram.org/" . $botID;
    $content = file_get_contents("php://input");
    $update = json_decode($content, TRUE);
    $message = $update["message"];

    $chatID = $message["chat"]["id"];
    $first_name = $message["chat"]["first_name"];
    $command = $message["text"];

    if( isset($message["photo"] )){
       getFile( $message["photo"] );
       return true;
    }


    switch ($command) {
        case "/hello":
            sendMessage( "Hallo $first_name" );
            break;
        default:
            sendMessage( "Hallo $first_name, Dein Sharepic wird erstellt. Das kann bis zu einer Minute dauern." );
            $command = sprintf('python ../api/api.py --text \'%s\'', $command );
            
            shell_exec($command);
            sendFile( 'sharepic.png');
    }


}


function getFile( $message ){
    global $botID, $chatID;
    $botURL = "https://api.telegram.org/$botID/";

    // get Photo ID
    $last = count($message) - 1;
    $photoID = $message[ $last ]["file_id"];

    // get Photo Info with path
    $url = $botURL . "getFile?file_id=" . $photoID;
    $photoInfo = json_decode(file_get_contents( $url), TRUE);
    $path = $photoInfo["result"]["file_path"];

    // download file
    $url = "https://api.telegram.org/file/$botID/" . $path;
    copy( $url, "../api/picture.jpg");

    sendMessage("Dein Bild ist angekommen. Welcher Text soll drauf?");
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

function sendMessage($message)
{
    if (!$message) return;
    global $botID, $chatID;
    readfile('https://api.telegram.org/' . $botID . '/sendMessage?chat_id=' . $chatID . '&text=' . $message);
}