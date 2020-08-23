<?php

function saveInGallery($filename, $tenant)
{
    $directory = sprintf("tenants/%s/gallery/img/", $tenant );
    $command = sprintf(
        "convert %s -background white -flatten -resize 800x800 -quality 75 %s",
        getBasePath('tmp/' . basename($filename, 'svg') . 'jpg'),
        getBasePath( $directory . basename($filename, 'svg') . 'jpg')
    );
    exec($command);

    $info = array(
        "Nutzer*in"=>sanitizeUserinput($_POST['user'])
    );
    file_put_contents(getBasePath( $directory . basename($filename, 'svg') . 'json'), json_encode($info));
}
