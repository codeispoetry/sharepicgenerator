<?php

function convertExoticExtensions($filebasename, $extension)
{
    $filename = $filebasename . '.' . $extension;

    // convert webp to jpg, as inkscape cannot handle webp
    if (strToLower($extension) == 'webp') {
        $newFilename = $filebasename .'.jpg';
        $command = sprintf(
            "dwebp %s -o %s",
            $filename,
            $newFilename
        );
        exec($command);
        $filename = $newFilename;

        return $newFilename;
    }

    // convert heic
    if (strToLower($extension) == 'heic') {
        $newFilename = $filebasename .'.jpg';
        $command = sprintf(
            "heif-convert %s %s",
            $filename,
            $newFilename
        );
        exec($command);
        $filename = $newFilename;

        return $newFilename;
    }

    return $filebasename;
}

function handleBackgroundUpload($extension)
{
    $filebasename = getBasePath('tmp/' . uniqid('upload', true));
    $filename = $filebasename . '.' . $extension;

    $moved = move_uploaded_file($_FILES['file']['tmp_name'], $filename);

    // convert webp to jpg, as inkscape cannot handle webp
    if (in_array(strToLower($extension), ['webp','heic'])) {
        $filename = convertExoticExtensions($filebasename, $extension);
        $extension = 'jpg';
    }


    $filesJoin = join(':', $_FILES['file']);

    $line = sprintf("%s\t%s\t%s\t%s\t%s\n", time(), $filename, $moved, $filesJoin, getUser());

    file_put_contents(getBasePath('log/logs/uploads.log'), $line, FILE_APPEND);

    $filename_small = $filebasename . '_small.' . $extension;
    prepareFileAndSendInfo($filename, $filename_small);
}

function handleIconUpload($extension)
{
    $filebasename = getBasePath('tmp/' . uniqid('icon'));
    $filename = $filebasename . '.' . $extension;

    move_uploaded_file($_FILES['file']['tmp_name'], $filename);

    $return['iconfile'] = '../' . $filename;
    $return['okay'] = true;

    echo json_encode($return);
}

function handleUploadWork()
{
    $filebasename = getBasePath('tmp/' . uniqid('work'));
    $filename = $filebasename . '.zip';
    $savedir = getBasePath('tmp/' . basename($filename, '.zip'));

    move_uploaded_file($_FILES['file']['tmp_name'], $filename);

    $cmd = sprintf('unzip %s -d %s 2>&1', $filename, $savedir);
    exec($cmd, $output);

    $cmd = unlink($filename);
    exec($cmd, $output);

    $cmd = sprintf("chmod -R 777 %s", $savedir);
    exec($cmd, $output);

    $return['okay'] = true;
    //$return['debug'] = $output;

    $datafile = $savedir . '/data.json';
    $json = file_get_contents($datafile);

    $return['data'] = $json;
    $return['dir'] = $savedir;

    echo json_encode($return);
}

function handleAddPicUpload($extension)
{
    $filebasename = getBasePath('tmp/' . uniqid('addpic'));
    $filename = $filebasename . '.' . $extension;

    move_uploaded_file($_FILES['file']['tmp_name'], $filename);

    $command = sprintf("mogrify -auto-orient %s", $filename);
    exec($command);

    $return['addpicfile'] = '../' . $filename;
    $return['okay'] = true;

    echo json_encode($return);
}

function handleLogoUpload($extension)
{
    if (!isAllowed()) {
        returnJsonErrorAndDie('not allowed');
    }

    $userDir = getUserDir();

    $filename = $userDir . '/' . uniqid('logo_') . '.' . $extension;
    move_uploaded_file($_FILES['file']['tmp_name'], $filename);

    if ($extension != 'png') {
        $command = sprintf(
            "convert -resize 500x500 -background none %s %s/%s.png",
            $filename,
            $userDir,
            pathinfo($filename, PATHINFO_FILENAME)
        );
        exec($command);
        unlink($filename);
    }

    $return['okay'] = true;
    $return['file'] = $filename;

    echo json_encode($return);
    die();
}

function handleTmpLogoUpload($extension)
{
    if (!isAllowed()) {
        returnJsonErrorAndDie('not allowed');
    }

    $filename = getBasePath('tmp/' . uniqid('logo_')) . '.' . $extension;
    move_uploaded_file($_FILES['file']['tmp_name'], $filename);

    $return['okay'] = true;
    $return['file'] = basename($filename);

    echo json_encode($return);
    die();
}

function isFileAllowed($extension, $allowed)
{
    return in_array(strtolower($extension), $allowed);
}

function handleVideoUpload($extension)
{
    $basename = getBasePath('tmp/' . uniqid('video'));
    $videofile = $basename . '.' . $extension;
    $thumbnail =  $basename . '.jpg';

    move_uploaded_file($_FILES['file']['tmp_name'], $videofile);
    editVideoAndSendInfo($videofile, $thumbnail);
}


function editVideoAndSendInfo($videofile, $thumbnail)
{
    $command =sprintf('ffmpeg -ss 00:00:02 -i %s -vframes 1 -q:v 2 %s 2>&1', $videofile, $thumbnail);
    exec($command, $output);

    $return['filename'] = '../' . $thumbnail;
    $return['videofile'] = $videofile;
    list($width, $height, $type, $attr) = getimagesize($thumbnail);

    $command = sprintf(
        'ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 %s',
        $videofile
    );
    exec($command, $duration);

    $return['width'] = $width;
    $return['height'] = $height;
    $return['originalWidth'] = $width;
    $return['originalHeight'] = $height;
    $return['video'] = 1;
    $return['videoduration'] = $duration;

    echo json_encode($return);
    die();
}

function handleUploadByUrl()
{
    $url = $_POST['url2copy'];
    $extension = pathinfo(parse_url($_POST['url2copy'], PHP_URL_PATH), PATHINFO_EXTENSION);

    // handle video upload
    if (substr($extension, 0, 3) == 'mp4') {
        $basename = getBasePath('tmp/' . uniqid('video'));
        $videofile = $basename . '.mp4';
        $thumbnail =  $basename . '.jpg';

        if (!copy($url, $videofile)) {
            echo json_encode(array("error"=>"could not copy video file"));
            die();
        }
        editVideoAndSendInfo($videofile, $thumbnail);

        return;
    }

    $filebasename = getBasePath('tmp/' . uniqid('upload'));
    $filename = $filebasename . '.' . $extension;
    $filename_small = $filebasename . '_small.' . $extension;

    if (!copy($url, $filename)) {
        echo json_encode(array("error"=>"could not copy file"));
        die();
    }

    prepareFileAndSendInfo($filename, $filename_small);
}

function prepareFileAndSendInfo($filename, $filename_small)
{
    $command = sprintf(
        "mogrify -auto-orient %s",
        $filename
    );
    exec($command);

    $command = sprintf(
        "convert %s[800x800] -resize 800x450 %s",
        $filename,
        $filename_small
    );
    exec($command);

    $return['filename'] = '../' . $filename_small;
    list($width, $height, $type, $attr) = getimagesize($filename_small);
    list($originalWidth, $originalHeight, $type, $attr) = getimagesize($filename);

    $return['width'] = $width;
    $return['height'] = $height;
    $return['originalWidth'] = $originalWidth;
    $return['originalHeight'] = $originalHeight;
    $return['fullBackgroundName'] = $filename;
    $return['faces'] = countFaces($filename);

    echo json_encode($return);
    die();
}

function countFaces($filename)
{
    $command = sprintf("facedetect %s", $filename);
    exec($command, $output);
    return count($output);
}
