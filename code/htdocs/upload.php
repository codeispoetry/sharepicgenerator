<?php

$data = $_POST['data'];

if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
    $data = substr($data, strpos($data, ',') + 1);
    $type = strtolower($type[1]); // jpg, png, gif

    if (!in_array($type, [ 'jpg', 'jpeg', 'png' ])) {
        throw new \Exception('invalid image type');
    }

    $data = base64_decode($data);

    if ($data === false) {
        throw new \Exception('base64_decode failed');
    }
} else {
    throw new \Exception('did not match data URI with image data');
}

if($type == 'jpeg') $type = 'jpg';

$filename = 'tmp/' . uniqid('upload') . '.' . $type;
file_put_contents($filename, $data);

$return = [];
$return['filename'] = $filename;
list($width, $height, $type, $attr) = getimagesize( $filename );
$factor= 0.3;
$return['width'] =  $width * $factor;
$return['height'] = $height * $factor;

echo json_encode( $return );
