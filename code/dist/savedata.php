<?php


exec("rm persistent/*.json");
$filename = 'persistent/' . uniqid(). '.json';
exec(" chmod 777 persistent/*");

$data = $_POST['data'];
$data = preg_replace("/_small/", "", $data );

$success = @file_put_contents( $filename, $data );

$return = [];
$return['success'] = $success;
$return['file'] = $filename;



echo json_encode($return);