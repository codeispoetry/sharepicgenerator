<?php

function saveInGallery($filename, $tenant)
{
    $directory = sprintf("tenants/%s/gallery/img/", $tenant);
    $command = sprintf(
        "convert %s -background white -flatten -resize 800x800 -quality 75 %s",
        getBasePath('tmp/' . basename($filename, 'svg') . 'jpg'),
        getBasePath($directory . basename($filename, 'svg') . 'jpg')
    );
    exec($command);

    $info = array(
        "Nutzer*in"=>sanitizeUserinput($_POST['user'])
    );
    file_put_contents(getBasePath($directory . basename($filename, 'svg') . 'json'), json_encode($info));
}

function showImages($dir)
{
    $files = array_reverse(glob($dir));
    foreach ($files as $file) {
        $info = array(
            'Datum' => strftime('%e. %B %Y', filemtime($file)),
            'ID' => basename($file, '.jpg'),
        );

        $infofile = 'img/' . basename($file, 'jpg').'json';
        if (file_exists($infofile)) {
            $info = array_merge(json_decode(file_get_contents($infofile), true), $info);
        }

        echo <<<EOHEADER
        <div class="col-6 col-md-3 col-lg-3">
            <figure>
                <img src="$file" class="img-fluid" />
                <figcaption>
                    <table class="small">
EOHEADER;
        foreach ($info as $key => $value) {
            echo <<<EOLINE
                        <tr>
                            <td class="pr-3 ">$key</td>
                            <td>$value</td>
                        </tr>
EOLINE;
        }
        echo <<<EOFOOTER
                    </table>
                </figcaption>
            </figure>
        </div>
EOFOOTER;
    }
}
