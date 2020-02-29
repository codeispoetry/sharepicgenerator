<?php

$file = sprintf('../tmp/%s.svg', basename($_GET['file']));

$backgroundFile = preg_match('/xlink:href="(.*?)"/', file_get_contents($file), $matches);


echo '<h2>Pfad in der SVG-Datei</h2>';
echo $matches[1];

echo '<h2>Auszug aus der Uploads.log-Datei</h2>';
$lines = file('uploads.log');
foreach($lines AS $line){
    if(preg_match("/$backgroundFile/", $line)){
        echo $line;
    break;
    }
}


printf('<hr><img src="%s">', $_GET['picture']);
