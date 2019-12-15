<?php


if( !isset($_GET['file'])){
     die("0");
}
$file = $_GET['file'];


if( !file_exists($file)){
    $file = $file . '.svg';
}

if( !file_exists($file)){    
    die("1");
}

if( strToLower(mime_content_type( $file )) !== "image/svg" ){
    die("2");
}

$svg = file_get_contents($file);

$svg = preg_replace('/<path /', '<path fill="white" ',$svg);

header('Content-type: image/svg+xml');
echo $svg;