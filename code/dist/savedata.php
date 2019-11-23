<?php


exec("rm persistent/*.json");
$filename = 'persistent/' . uniqid() . '.json';
$filename ="persistent/test.json";
exec(" chmod 777 -r persistent/");

// get user input
$data = json_decode($_POST['data']);

// sanitiz user input
if (json_last_error() != JSON_ERROR_NONE) {
    die(json_encode(['success' => false, 'code' => 'nojson']));
}

// copy file to tmp
$pic = $data->backgroundURL;
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