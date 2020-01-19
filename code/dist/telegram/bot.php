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
    file_put_contents('botlog1.txt', $content);
    $update = json_decode($content, TRUE);
    $message = $update["message"];

    $chatID = $message["chat"]["id"];
    $first_name = $message["chat"]["first_name"];
    $command = $message["text"];

    if( isset($message["photo"] )){
       getFile( $message["photo"] );
       return true;
    }

    if( isset($message["document"] )){
        sendMessage( "Bitte sende Dein Bild als Bild und nicht als Datei." );
        return true;
     }


    switch ($command) {
        case "/hello":
            sendMessage( "Hallo $first_name,\nich bin der Bayernbot. Schicke mir ein Bild oder einen Text und erhalte Deine Sharepic." );
            break;
        case "/help":
            sendMessage( "Schicke ein Bild und folge dann den Aweisungen. Oder schicke einen Text.\n\nKommandos:\n/get Zeigt das Hintergrundbild an\n/help Zeigt diese Beschreibung an\n/delete Löscht Dein Hintergrundbild" );
            break;
        case "/start":
            sendMessage( "Willkommen beim Bayernbot. Schicke ein Bild und folge dann den Aweisungen oder schicke einen Text und warte.\n\nKommandos:\n/get Zeigt das Hintergrundbild an\n/help Zeigt diese Beschreibung an\n/delete Löscht Dein Hintergrundbild" );
            break;
        case "/get":
            $bgfile = sprintf('../api/user/%s/picture.jpg', $chatID);
            if( file_exists($bgfile)){
                sendFile($bgfile );
            }else{
                sendMessage( "Du hast kein Hintergrundbild gespeichert. Schick mir doch einfach eines zu.");
            }
            break;
        case "/delete":
            unlink(sprintf('../api/user/%s/picture.jpg', $chatID) );
            sendMessage( "Dein Hintergrundbild wurde gelöscht.");
            break;
        default:
            sendMessage( "Hallo $first_name, Dein Sharepic wird erstellt. Das kann bis zu einer Minute dauern." );
            
            file_put_contents( '../api/data.json', json_encode(array("text"=> $command, "chatID"=> $chatID)));
            
            $command ='python ../api/api.py 2>&1 1>/dev/null';
            
            $result = shell_exec($command);
            if( $result == ""){
                sendFile( 'sharepic.jpg');
            }else{
                sendMessage( "Es ist ein Fehler passiert. Es folgt die Fehlermeldung:" );
                sendMessage( $result );
            }
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

    $userDir = sprintf('../api/user/%s', $chatID);
    if( !file_exists( $userDir )){
        mkdir( $userDir );
    }

    copy( $url, sprintf('%s/picture.jpg', $userDir ));

    sendMessage("Dein Bild ist angekommen. Welcher Text soll drauf?\nZeilen, die mit einem ! beginnen, werden größer dargestellt.");
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
    readfile('https://api.telegram.org/' . $botID . '/sendMessage?chat_id=' . $chatID . '&text=' . urlencode($message));
}