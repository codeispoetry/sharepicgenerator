<?php
$basename = uniqid('save');
$filename = 'tmp/' . $basename . '.ser';
$zipfile = 'tmp/' . $basename .'.zip';

$data = $_POST['data'];

file_put_contents( $filename, $data );

// extract
$values = array();
parse_str($data, $values);
$backgroundfile = $values[ 'fullBackgroundName' ];

// zip
$command = sprintf('zip -j %s %s %s 2>&1', $zipfile, $filename, $backgroundfile);
exec( $command );


// rename
$command = sprintf('printf "@ %s\n@=data.ser\n" | zipnote -w %s 2>&1', basename($filename), $zipfile);
exec( $command, $output );

$ext = pathinfo( $backgroundfile, PATHINFO_EXTENSION);
$command = sprintf('printf "@ %s\n@=background.%s\n" | zipnote -w %s 2>&1', basename( $backgroundfile ), $ext, $zipfile);
exec( $command, $output );


$return = array(
    "status" => 200,
    "basename" => $basename,

);

echo json_encode( $return );