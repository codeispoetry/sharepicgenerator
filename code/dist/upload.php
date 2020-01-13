<?php

$data = $_POST['data'];
$id = $_POST['id'];
$return = [];

$extension = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);

if (!is_file_allowed($extension, array('jpg','png','gif','svg','mp4')) ){
    echo json_encode(array("error"=>"wrong fileformat"));
    die();
}

if( $id == "uploadfile"){
    if($extension == 'mp4'){
        handle_video_upload();
    }
    handle_background_upload();
}

if( $id == "uploadlogo"){
    handle_logo_upload();
}

echo json_encode(array("error"=>"nothing done"));
die();

function handle_background_upload(){
    global $extension;

    $filebasename = 'tmp/' . uniqid('upload');
    $filename = $filebasename . '.' . $extension;
    $filename_small = $filebasename . '.' . $extension;

    move_uploaded_file($_FILES['file']['tmp_name'], $filename );

    $command = sprintf("mogrify -auto-orient %s",
        $filename
    );
    exec($command);

    $command = sprintf("convert -resize 800x450 %s %s",
        $filename,
        $filename_small
    );
    exec($command);


    $return['filename'] = $filename_small;
    list($width, $height, $type, $attr) = getimagesize($filename_small);
    list($originalWidth, $originalHeight, $type, $attr) = getimagesize($filename);

    $return['width'] = $width;
    $return['height'] = $height;
    $return['originalWidth'] = $originalWidth;
    $return['originalHeight'] = $originalHeight;


    echo json_encode($return);
    die();
}

function handle_logo_upload(){
    global $extension;

    $user = preg_replace('/[^a-zA-Z0-9]/','', $_POST['user']);

    $userDir = 'persistent/user/' . $user;
    if( !file_exists($userDir)){
        mkdir($userDir);
    }

    $filename = $userDir . '/logo.' . $extension;
    move_uploaded_file($_FILES['file']['tmp_name'], $filename );

    if( $extension != 'png'){
        $command = sprintf("convert -resize 500x500 -background none %s %s/logo.png",
            $filename,
            $userDir
        );
        exec($command);
    }

    $return['okay'] = true;
    echo json_encode($return);
    die();
}

function is_file_allowed( $extension, $allowed){
    return in_array( strtolower($extension), $allowed);
}

function handle_video_upload(){
    global $extension;
    $basename = 'tmp/' . uniqid('video');
    $videofile = $basename . '.' . $extension;
    $thumbnail =  $basename . '.jpg';


    move_uploaded_file($_FILES['file']['tmp_name'], $videofile );

    $command =sprintf('ffmpeg -ss 00:00:05 -i %s -vframes 1 -q:v 2 %s 2>&1', $videofile, $thumbnail);
    exec($command);

    $return['filename'] = $thumbnail;
    list($width, $height, $type, $attr) = getimagesize($thumbnail);
    
    $return['width'] = $width;
    $return['height'] = $height;
    $return['originalWidth'] = $width;
    $return['originalHeight'] = $height;
    $return['video'] = 1;

    echo json_encode($return);
    die();
}
