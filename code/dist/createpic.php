<?php

$filename = 'tmp/' . uniqid('shpic') . '.svg';

$svg = $_POST['svg'];
$svg = preg_replace('/_small/', '', $svg);

$svgHeader = '<?xml version="1.0" standalone="no"?>'; // XML node needed by imagick
$svgTag = 'svg'; // tag to search for
preg_match_all("/\<svg(.*?)\>/", $svg, $matches); // Get initial SVG node that may contain missing :xlink

// Für den Safari
if (!preg_match("/xmlns:xlink/", $matches[1][0])) {
    $tempString = str_replace_nth('xmlns=', 'xmlns:xlink=', $matches[1][0], 1); // Replace second occurance of xmlns
    $svg = str_replace($matches[1][0], $tempString, $svg);
}

$svg = preg_replace('/NS([1-9]|[1-9][0-9]|[1-9][0-9][0-9]):/', 'xlink:', $svg); // Remove offending NS<number>: in front of href tags, will only remove NS0 - NS999


// Für den Firefox
$svg = preg_replace('#([^:])\/\/#', "$1/", $svg);


$svg = $svgHeader . $svg; // Prefix SVG string with required XML node




file_put_contents($filename, $svg);

if( in_array($_POST['format'], array('png','pdf','jpg','mp4'))){
    $format = $_POST['format'];
}else{
    die("wrong format");
}

$exportWidth = (int) $_POST['width'];
$quality = (int) $_POST['quality'] ?: 75;
convert($filename, $exportWidth, $format, $quality);

logthis();

$return = [];
$return['basename'] = basename($filename, 'svg');
echo json_encode($return);


function convert($filename, $width, $format, $quality = 75)
{
    if($format == 'pdf'){
        $tempformat = 'pdf';
    }else{
        $tempformat = 'png';
    }

    $command = sprintf("inkscape %s --export-width=%d --export-{$tempformat}=%s --export-dpi=90",
        $filename,
        $width,
        'tmp/' . basename($filename, 'svg') . $tempformat);
    exec($command);

    if($format == 'jpg'){
        $command = sprintf("convert %s -background white -flatten -quality %s %s",
            'tmp/' . basename($filename, 'svg') . $tempformat,
            $quality,
            'tmp/' . basename($filename, 'svg') . $format
        );
        exec($command);

        if( $_POST['ismosaic'] == "true"){
            $dir = 'tmp/' . basename($filename, '.svg');

            $command = sprintf('mkdir %s', $dir);
            exec( $command );

           copy('mosaik_readme.txt',sprintf('%s/z_anleitung.txt', $dir));

            $command = sprintf('convert %s -crop 3x3@ +repage +adjoin -scene 1 %s/bild_%%d.jpg', 'tmp/' . basename($filename, 'svg') . $format, $dir);
            exec( $command );

            $command = sprintf("montage %s/bild*.jpg -geometry 200x200+8+8 %s/gesamt.jpg", $dir, $dir );
            exec( $command );


            $command = sprintf('zip -j %s.zip %s/*', $dir, $dir);
            exec( $command );
        }
    }

    if($format == 'mp4'){
        $command =sprintf( 'ffmpeg -i %s -i %s -filter_complex "[0:v][1:v] overlay=0:0" -b:v 2M -pix_fmt yuv420p -c:a copy %s 2>%s',
            'tmp/'. basename($_POST['videofile']),
            'tmp/' . basename($filename, 'svg') . 'png',
            'tmp/' . basename($filename, 'svg') . 'mp4',
            'tmp/' . basename($_POST['videofile'], 'mp4') . 'log'
        );
        exec($command);
    }
}


function sanitize_userinput($var)
{
    return preg_replace('/[^a-zA-Z0-9]/', '', $var);
}


function logthis()
{
    $pixabay = sanitize_userinput( $_POST['usepixabay']);
    $socialmediaplatform = sanitize_userinput( $_POST['socialmediaplatform']);
    $line = sprintf("%s\t%s\t%s\t%s\t%s\n", time(), '',  'download', $pixabay, $socialmediaplatform);
    file_put_contents('log/log.log', $line, FILE_APPEND);
}