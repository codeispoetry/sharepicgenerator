<?php


$id = $_POST['id'];

$extension = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);

if (isset($_FILES['file']) && !is_file_allowed($extension, array('jpg','jpeg','png','gif','svg','mp4')) ){
    echo json_encode(array("error"=>"wrong fileformat"));
    die();
}

switch( $id ){
    case "uploadfile":
        if($extension == 'mp4'){
            handle_video_upload();
        }
        handle_background_upload();
        break;

    case "uploadlogo":
        handle_logo_upload();
        break;
    case "uploadicon":
        handle_icon_upload();
        break;
    case "uploadbyurl":
        handle_uploadbyurl();
        break;
    default:
        echo json_encode(array("error"=>"nothing done. id=" . $id));
        die();
}



function handle_background_upload(){
    global $extension;

    $filebasename = 'tmp/' . uniqid('upload');
    $filename = $filebasename . '.' . $extension;
    $filename_small = $filebasename . '_small.' . $extension;

    move_uploaded_file($_FILES['file']['tmp_name'], $filename );

    prepare_file_and_send_info($filename, $filename_small);

}


function handle_icon_upload(){
    global $extension;

    $filebasename = 'tmp/' . uniqid('icon');
    $filename = $filebasename . '.' . $extension;

    move_uploaded_file($_FILES['file']['tmp_name'], $filename );

    $return['iconfile'] = $filename;
    $return['okay'] = true;

    echo json_encode($return);

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
    $return['videofile'] = $videofile;
    list($width, $height, $type, $attr) = getimagesize($thumbnail);

    $command = sprintf('ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 %s', $videofile);
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

function handle_uploadbyurl(){
    $url = $_POST['url2copy'];
    $extension = pathinfo($url,PATHINFO_EXTENSION);

    $filebasename = 'tmp/' . uniqid('upload');
    $filename = $filebasename . '.' . $extension;
    $filename_small = $filebasename . '.' . $extension;

    if( !copy($url, $filename ) ){
        echo json_encode(array("error"=>"could not copy file"));
        die();
    }

    prepare_file_and_send_info($filename, $filename_small);
}

function prepare_file_and_send_info( $filename, $filename_small ){
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