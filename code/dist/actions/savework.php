<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));

$basename = uniqid('save');
$datafile = getBasePath('tmp/' . $basename . '.json');
$zipfile = getBasePath('tmp/' . $basename .'.zip');

$data = $_POST['data'];

// extract
$values = array();
parse_str($data, $values);
$backgroundfile = $values[ 'fullBackgroundName' ];
if ($values[ 'addpicfile1' ]) {
    $addpic1 = getBasePath('tmp/'. basename($values[ 'addpicfile1' ]));
}
if ($values[ 'addpicfile2' ]) {
    $addpic2 = getBasePath('tmp/'. basename($values[ 'addpicfile2' ]));
}
$ext = pathinfo($backgroundfile, PATHINFO_EXTENSION);
$newBackgroundName = 'background.' . $ext;

$values[ 'savedBackground' ] = $newBackgroundName;
if ($addpic1 != '') {
    $values[ 'addpicfile1' ] = 'addpic1.jpg';
}
if ($addpic2 != '') {
    $values[ 'addpicfile2' ] = 'addpic2.jpg';
}
unset($values[ 'backgroundURL' ]);

file_put_contents($datafile, json_encode($values));

// zip
$assets = "$backgroundfile $addpic1 $addpic2";
$command = sprintf('zip -j %s %s %s 2>&1', $zipfile, $datafile, $assets);
exec($command, $output);
$debug = $command;

// rename
$command = sprintf('printf "@ %s\n@=data.json\n" | zipnote -w %s 2>&1', basename($datafile), $zipfile);
exec($command, $output);

$command = sprintf('printf "@ %s\n@=%s\n" | zipnote -w %s 2>&1', basename($backgroundfile), $newBackgroundName, $zipfile);
exec($command, $output);

if ($addpic1 != '') {
    $command = sprintf('printf "@ %s\n@=%s\n" | zipnote -w %s 2>&1', basename($addpic1), 'addpic1.jpg', $zipfile);
    exec($command, $output);
}

if ($addpic2 != '') {
    $command = sprintf('printf "@ %s\n@=%s\n" | zipnote -w %s 2>&1', basename($addpic2), 'addpic2.jpg', $zipfile);
    exec($command, $output);
}

$return = array(
    "status" => 200,
    "debug" => $debug,
    "basename" => $basename,

);

echo json_encode($return);
