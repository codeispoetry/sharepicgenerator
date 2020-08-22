<?php

function saveInGallery($filename)
{
    $command = sprintf(
        "convert %s -background white -flatten -resize 800x800 -quality 75 %s",
        getBasePath('tmp/' . basename($filename, 'svg') . 'jpg'),
        getBasePath('gallery/img/' . basename($filename, 'svg') . 'jpg')
    );
    exec($command);

    $info = array(
        "Nutzer*in"=>sanitizeUserinput($_POST['user'])
    );
    file_put_contents(getBasePath('gallery/img/' . basename($filename, 'svg') . 'json'), json_encode($info));
}
