<?php

$file = sprintf('../tmp/%s.svg', basename($_GET['file']));

$backgroundFile = preg_match('/xlink:href="(.*?)"/', file_get_contents($file), $matches);


echo '<h2>Pfad in der SVG-Datei</h2>';
echo $matches[1];

echo '<h2>Auszug aus der Uploads.log-Datei</h2>';
$lines = file('logs/uploads.log');
foreach ($lines as $line) {
    if (preg_match('/' . basename($matches[1]) . '/', $line)) {
        echo $line;
    }
}

echo '<h2>Auszug aus der inotify.log-Datei</h2>';
$lines = file('inotify.log');
foreach ($lines as $line) {
    if (preg_match('/' . basename($matches[1]) . '/', $line)) {
        echo $line."<br>";
    }
}


printf('<hr>Sharepic<br><img src="%s">', $_GET['picture']);
printf('<hr>Upload in tmp<br><img src="/tmp/%s" height="200">', basename($matches[1]));
