<?php

// get user input
$data = json_decode($_POST['data']);

// sanitize user input
if (json_last_error() != JSON_ERROR_NONE) {
    die(json_encode(['success' => false, 'code' => 'nojson']));
}

exec("rm persistent/*.json");
exec(" chmod 777 -r persistent/");

// Get provided filename or fallback, sanitize
$filename = ($data->persistentname) ?: $data->text;
$filename = preg_replace('/[!\n]/','', $filename);
$filename = preg_replace('/[^a-zA-Z0-9]/','-', $filename);
$filename = preg_replace('/(\-+)/','-', $filename);
$filename = strtolower( $filename );


$filename = 'persistent/' .$filename . '.json';





// copy file to tmp
$pic = preg_replace('/_small/', '', $data->backgroundURL);
$persistent_pic = 'persistent/test.jpg';
copy( $pic, $persistent_pic);
$data->backgroundURL = $persistent_pic;

// save data
$success = file_put_contents($filename, json_encode($data));

// return to sender
$return = [];
$return['success'] = $success;
$return['file'] = $filename;


echo json_encode($return);