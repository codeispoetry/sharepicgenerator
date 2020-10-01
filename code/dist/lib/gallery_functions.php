<?php

function ensureGalleryDir($tenant, $filename)
{
    $directory = sprintf("tenants/%s/gallery/img/%s/", $tenant, $filename);
    if (!file_exists(getBasePath($directory))) {
        mkdir(getBasePath($directory));
    }
    return $directory;
}

function saveOrigFile()
{
    $saveOrig = false;

    if (configValue("Gallery", "saveOrigFile") == 'true') {
        $saveOrig = true;
    }
    return $saveOrig;
}

function saveInGallery($file, $format, $tenant)
{
    $filename = basename($file, '.svg');
    $thumb = $filename . "_thumb.jpg";

    $directory = ensureGalleryDir($tenant, $filename);

    $command = sprintf(
        "convert %s -background white -flatten -resize 800x800 -quality 75 %s",
        getBasePath('tmp/' . basename($file, 'svg') . 'jpg'),
        getBasePath($directory . $thumb)
    );
    exec($command);

    $info = array(
      "Nutzer*in"=>sanitizeUserinput($_POST['user']),
      'Datum' => date("Y-m-d H:i:s"),
      'ID' => $filename
    );

    if (saveOrigFile() == true) {
        $origFilename = $filename . "." . $format;
        copy(getBasePath('tmp/' . $origFilename), getBasePath($directory . $origFilename));
        $info['origFile'] = $origFilename;
    }
    file_put_contents(getBasePath($directory . 'info.json'), json_encode($info));
}

function saveWorkInGallery($zipfile, $tenant, $filename)
{
    $directory = ensureGalleryDir($tenant, $filename);
    copy($zipfile, getBasePath($directory . "save_" . $filename . ".zip"));
}

function showImages($dir_glob)
{
    $dirs = array_reverse(glob($dir_glob, GLOB_ONLYDIR));
    foreach ($dirs as $shpic) {
        $thumb = $shpic . '/' . basename($shpic) . '_thumb.jpg';
        $infofile = $shpic . '/info.json';

        if (file_exists($infofile)) {
            $info = json_decode(file_get_contents($infofile), true);
        }
        $id = $info['ID'];
        $user = $info['Nutzer*in'];
        $date = $info['Datum'];

        $origLink='';
        if (isset($info['origFile'])) {
            $origFilePath = $shpic . '/' . $info['origFile'];
        }

        $saveLink='';
        $saveFile = $shpic . '/save_' . basename($shpic) . '.zip';

        if (file_exists($saveFile)) {
            $saveLink = "<a href='". $saveFile ."' download><i class='fas fa-download'></i> Download Arbeitsdatei</a>";
            $useLink = "<a href='../index.php?useSavework=gallery/".$saveFile ."' ><i class='fas fa-wrench'></i> weiterbearbeiten</a>";
        }

        $additional = "<tr> <td class=\"pr-3\"></td><td> $useLink</td></tr>";
        // <a href="$origFilePath" class="samplesharepic-image" download>
        echo <<<EOL
        <div class="col-6 col-md-3 col-lg-3">
            <figure class="samplesharepic">
                
                <img src="$thumb" class="img-fluid"/>

                <figcaption class="d-flex justify-content-around align-items-center">
                    <table class="small m-2">
                        <tr>
                            <td class="pr-3 ">Id</td>
                            <td>$id</td>
                        </tr>
                        <tr>
                            <td class="pr-3 ">Nutzer*in</td>
                            <td>$user</td>
                        </tr>
                        $additional
                    </table>
                </figcaption> 
            </figure>
        </div>
EOL;
    }
}
