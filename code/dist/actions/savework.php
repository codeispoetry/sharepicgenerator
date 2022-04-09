<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/gallery_functions.php'));
useDeLocale();

session_start();

if (!isAllowed(true)) {
    die();
}

$basename = uniqid('save');
$datafile = getBasePath('tmp/' . $basename . '.json');
$zipfile = getBasePath('tmp/' . $basename .'.zip');

$data = $_POST['data'];

// extract
$values = array();
parse_str($data, $values);
$backgroundfile = $values[ 'fullBackgroundName' ];
for ($i = 1; $i <=5; $i++) {
    if ($values[ 'addpicfile' . $i ]) {
        ${"addpic" . $i}  = getBasePath('tmp/'. basename($values[ 'addpicfile' . $i ]));
        $values[ 'addpicfile' . $i ] = 'addpic' . $i .'.jpg';
    }
}

$ext = pathinfo($backgroundfile, PATHINFO_EXTENSION);
$newBackgroundName = 'background.' . $ext;

$values[ 'savedBackground' ] = $newBackgroundName;
unset($values[ 'backgroundURL' ]);

file_put_contents($datafile, json_encode($values));

// zip
$assets = "$backgroundfile $addpic1 $addpic2 $addpic3 $addpic4 $addpic5";
$command = sprintf('zip -j %s %s %s 2>&1', $zipfile, $datafile, $assets);
exec($command, $output);
$debug = $command;

// rename
$command = sprintf('printf "@ %s\n@=data.json\n" | zipnote -w %s 2>&1', basename($datafile), $zipfile);
exec($command, $output);

$command = sprintf('printf "@ %s\n@=%s\n" | zipnote -w %s 2>&1', basename($backgroundfile), $newBackgroundName, $zipfile);
exec($command, $output);

for ($i = 1; $i <=5; $i++) {
    if (${"addpic" . $i} != '') {
        $command = sprintf('printf "@ %s\n@=%s\n" | zipnote -w %s 2>&1', basename(${"addpic" . $i}), 'addpic' . $i .'.jpg', $zipfile);
        exec($command, $output);
    }
}

$return = array(
    "status" => 200,
    "debug" => $debug,
    "basename" => $basename,

);

echo json_encode($return);
