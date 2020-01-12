<?php

$data = $_POST['data'];
$id = $_POST['id'];
$return = [];

$extension = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);

move_uploaded_file($_FILES['file']['tmp_name'],sprintf('tmp/%s.%s', uniqid('upload'), $extension));
echo json_encode($return);
die();
$prefix="upload";
if( $id == "uploadlogo"){
    $prefix = "logo";
}

if (preg_match('/^data:(image|video)\/([\w\+]+);base64,/', $data, $base64type)) {
    $data = substr($data, strpos($data, ',') + 1);
    $type = strtolower($base64type[2]); // jpg, png, gif

    if (!in_array($type, ['jpg', 'jpeg', 'png', 'svg+xml','mp4'])) {
        throw new \Exception('invalid file type');
    }

    $data = base64_decode($data);

    if ($data === false) {
        throw new \Exception('base64_decode failed');
    }
} else {
    throw new \Exception($data.'did not match data URI with image data');
}


if( $base64type[1] == 'video' ){
    $basename = 'tmp/' . uniqid('video');
    $videofile = $basename . '.' . $type;
    $thumbnail =  $basename . '.jpg';


    file_put_contents($videofile, $data);

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


if ($type == 'jpeg') $type = 'jpg';

if( $prefix == "logo"){
    $return['okay'] = true;

    $user = preg_replace('/[^a-zA-Z0-9]/','', $_POST['user']);

    $userDir = 'persistent/user/' . $user;
    if( !file_exists($userDir)){
        mkdir($userDir);
    }

    $filename = $userDir . '/logo.' . $type;
    file_put_contents($filename, $data);

    if( $type != 'png'){
        $command = sprintf("convert -resize 500x500 %s %s/logo.png",
            $filename,
            $userDir
        );
        exec($command);
    }
   

    echo json_encode($return);
    die();
}



$filebasename = 'tmp/' . uniqid('upload');
$filename = $filebasename . '.' . $type;
$filename_small = $filebasename . '_small.' . $type;

file_put_contents($filename, $data);


$command = sprintf("mogrify -auto-orient %s",
    $filename
);
exec($command);

$command = sprintf("convert -resize 800x450 %s %s",
    $filename,
    $filebasename . '_small.' . $type
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