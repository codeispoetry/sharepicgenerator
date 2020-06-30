<?php
$basename = uniqid('save');
$filename = 'tmp/' . $basename . '.json';
$zipfile = 'tmp/' . $basename .'.zip';

$data = $_POST['data'];


// extract
$values = array();
parse_str($data, $values);
$backgroundfile = $values[ 'fullBackgroundName' ];
$ext = pathinfo( $backgroundfile, PATHINFO_EXTENSION);
$newBackgroundName = 'background.' . $ext;

$values[ 'savedBackground' ] = $newBackgroundName;
unset( $values[ 'backgroundURL' ] );

file_put_contents( $filename, json_encode( $values ) );


// zip
$command = sprintf('zip -j %s %s %s 2>&1', $zipfile, $filename, $backgroundfile);
exec( $command );


// rename
$command = sprintf('printf "@ %s\n@=data.json\n" | zipnote -w %s 2>&1', basename($filename), $zipfile);
exec( $command, $output );


$command = sprintf('printf "@ %s\n@=%s\n" | zipnote -w %s 2>&1', basename( $backgroundfile ), $newBackgroundName, $zipfile);
exec( $command, $output );


$return = array(
    "status" => 200,
    "basename" => $basename,

);

echo json_encode( $return );