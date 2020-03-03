<?php
$filename = sanitize_userinput($_GET['file']);
$downloadname = $_GET['downloadname'] ?: 'sharepic';


if( !in_array($_GET['format'], array('png','pdf','jpg','mp4'))){
    die("wrong format");
}

switch($_GET['format']){
    case 'png':
        $contentType = 'image/png';
        $format = 'png';
    break;
    case 'pdf':
        $contentType = 'application/pdf';
        $format = 'pdf';
    break;
    case 'mp4':
        $contentType = 'video/mp4';
        $format = 'mp4';
    break;
    default:
        $contentType = 'image/jpg';
        $format = 'jpg';

}

debug($filename, $format);



header('Content-Type: ' . $contentType);
header("Content-Length: ".filesize('tmp/' . $filename . '.' . $format));
header('Content-Disposition: attachment; filename="' . $downloadname . '.' . $format . '"');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
readfile('tmp/' . $filename . '.' . $format);


tidyup();

function tidyup(){
    global $filename, $format;

    if($format == 'mp4'){
        return;
    }

    $command = sprintf("convert -resize 500x500 -background white -flatten -quality 60  %s %s",
        'tmp/' . $filename . '.png',
        'tmp/log' . time() . '_' . $filename . '.jpg'
    );
    exec($command);

    //unlink('tmp/' . $filename . '.' . $format);
    //unlink('tmp/' . $filename . '.svg');
    //unlink('tmp/' . $filename . '.png');
    
}




function sanitize_userinput($var)
{
    return preg_replace('/[^a-zA-Z0-9]/', '', $var);
}


function debug( $filename, $format ){
    $get = http_build_query($_GET,'',', ');
    $file = 'tmp/' . $filename . '.' . $format;
    if(file_exists($file)){
        $size = filesize($file);
    }else{
        $size = -1;
    }
    
    $debug = sprintf("%s\t%s\t%s\t%s\n", time(), $filename, $size, $get);
    file_put_contents('log/error.log', $debug, FILE_APPEND);
}