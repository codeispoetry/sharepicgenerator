<?php

$file = sprintf('../tmp/%s.svg', basename($_GET['file']));

$backgroundFile = preg_match('/xlink:href="(.*?)"/', file_get_contents($file), $matches);


echo '<h2>Pfad in der SVG-Datei</h2>';
echo $matches[1];

echo '<h2>Auszug aus der Uploads.log-Datei</h2>';
$lines = file('uploads.log');
foreach($lines AS $line){
    if(preg_match('/' . basename($matches[1]) . '/', $line)){
        echo $line;
    }
}

echo '<h2>Auszug aus der inotify.log-Datei</h2>';
$lines = file('inotify.log');
foreach($lines AS $line){
    if(preg_match('/' . basename($matches[1]) . '/', $line)){
        echo $line;
    }
}


printf('<hr>Sharepic<img src="%s">', $_GET['picture']);
printf('<hr>Uplod in debug<img src="/debug/tmp/%s" height="200">', basename($matches[1]));
printf('<hr>Upload in tmp<img src="/tmp/%s" height="200">', basename($matches[1]));
