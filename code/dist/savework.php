<?php
$basename = uniqid('save');
$datafile = 'tmp/' . $basename . '.json';
$zipfile = 'tmp/' . $basename .'.zip';

$data = $_POST['data'];


// extract
$values = array();
parse_str($data, $values);
$backgroundfile = $values[ 'fullBackgroundName' ];
$addpic1 = 'tmp/'. basename($values[ 'addpicfile1' ]) ?: '';
$addpic2 = 'tmp/'. basename($values[ 'addpicfile2' ]) ?: '';
$ext = pathinfo( $backgroundfile, PATHINFO_EXTENSION);
$newBackgroundName = 'background.' . $ext;

$values[ 'savedBackground' ] = $newBackgroundName;
unset( $values[ 'backgroundURL' ] );

file_put_contents( $datafile, json_encode( $values ) );


// zip
$assets = "$backgroundfile $addpic1 $addpic2";
$command = sprintf('zip -j %s %s %s 2>&1', $zipfile, $datafile, $assets);
exec( $command, $output );
$debug = $command;

// rename
$command = sprintf('printf "@ %s\n@=data.json\n" | zipnote -w %s 2>&1', basename($datafile), $zipfile);
exec( $command, $output );


$command = sprintf('printf "@ %s\n@=%s\n" | zipnote -w %s 2>&1', basename( $backgroundfile ), $newBackgroundName, $zipfile);
exec( $command, $output );


$return = array(
    "status" => 200,
    "debug" => $debug,
    "basename" => $basename,

);

echo json_encode( $return );