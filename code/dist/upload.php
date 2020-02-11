<?php

require_once( 'functions.php');
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

    $line = sprintf("%s\t%s\t%s\n", time(), $filename, $_FILES['file']['tmp_name']);
    file_put_contents('log/uploads.log', $line, FILE_APPEND);

    prepare_file_and_send_info($filename, $filename_small);

}


function handle_icon_upload(){
    global $extension;

    $filebasename = 'tmp/' . uniqid('icon');
    $filename = $filebasename . '.' . $extension;

    move_uploaded_file($_FILES['file']['tmp_name'], $filename );

    $return['iconfile'] = '../' . $filename;
    $return['okay'] = true;

    echo json_encode($return);

}

function handle_logo_upload(){
    global $extension;

    if( !isAllowed() ) {
        returnJsonErrorAndDie('not allowed');
    }

    $userDir = getUserDir();

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
    edit_video_and_send_info( $videofile, $thumbnail);
}


function edit_video_and_send_info( $videofile, $thumbnail){

    $command =sprintf('ffmpeg -ss 00:00:05 -i %s -vframes 1 -q:v 2 %s 2>&1', $videofile, $thumbnail);
    exec($command, $output);

    $return['filename'] = '../' . $thumbnail;
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

    // handle video upload
    if(substr($extension,0,3) == 'mp4'){
        $basename = 'tmp/' . uniqid('video');
        $videofile = $basename . '.mp4';
        $thumbnail =  $basename . '.jpg';
    
        if( !copy($url, $videofile ) ){
            echo json_encode(array("error"=>"could not copy video file"));
            die();
        }
        edit_video_and_send_info( $videofile, $thumbnail);

        return;
    }


    $filebasename = 'tmp/' . uniqid('upload');
    $filename = $filebasename . '.' . $extension;
    $filename_small = $filebasename . '_small.' . $extension;


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


    $return['filename'] = '../' . $filename_small;
    list($width, $height, $type, $attr) = getimagesize($filename_small);
    list($originalWidth, $originalHeight, $type, $attr) = getimagesize($filename);

    $return['width'] = $width;
    $return['height'] = $height;
    $return['originalWidth'] = $originalWidth;
    $return['originalHeight'] = $originalHeight;
    $return['fullBackgroundName'] = $filename;

    echo json_encode($return);
    die();
}


