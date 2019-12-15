<?php

$data = $_POST['data'];

if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
    $data = substr($data, strpos($data, ',') + 1);
    $type = strtolower($type[1]); // jpg, png, gif

    if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
        throw new \Exception('invalid image type');
    }

    $data = base64_decode($data);

    if ($data === false) {
        throw new \Exception('base64_decode failed');
    }
} else {
    throw new \Exception('did not match data URI with image data');
}

if ($type == 'jpeg') $type = 'jpg';

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


$return = [];
$return['filename'] = $filename_small;
list($width, $height, $type, $attr) = getimagesize($filename_small);
list($originalWidth, $originalHeight, $type, $attr) = getimagesize($filename);

$return['width'] = $width;
$return['height'] = $height;
$return['originalWidth'] = $originalWidth;
$return['originalHeight'] = $originalHeight;


echo json_encode($return);

deleteOldFiles();
function deleteOldFiles()
{
    $files = scandir('tmp');
    $now = time();
    foreach ($files as $file) {
        if( substr($file,0,1) == '.' ) continue;
        
        $file = 'tmp/' . $file;
        if (is_file($file) AND $now - filemtime($file) >= 60 * 60 * 24 * 7)
            unlink($file);
    }
}
