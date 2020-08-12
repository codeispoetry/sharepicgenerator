<?php

function saveInGallery($filename)
{
    $command = sprintf(
        "convert %s -background white -flatten -resize 800x800 -quality 75 %s",
        'tmp/' . basename($filename, 'svg') . 'jpg',
        'gallery/img/' . basename($filename, 'svg') . 'jpg'
    );
    exec($command);

    $info = array(
        "Nutzer*in"=>sanitizeUserinput($_POST['user'])
    );
    file_put_contents('gallery/img/' . basename($filename, 'svg') . 'json', json_encode($info));
}
