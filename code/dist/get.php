<?php

require_once('functions.php');

if( !isset($_POST['user'] )) die();
if( !isset($_POST['accesstoken'] )) die();

$user = preg_replace('/[^a-zA-Z0-9]/','', $_POST['user']);
$accesstoken = preg_replace('/[^a-zA-Z0-9]/','', $_POST['accesstoken']);
$action = preg_replace('/[^a-zA-Z0-9]/','', $_POST['action']);


if( !checkPermission( $user, $accesstoken )){
    die(json_encode(array("error"=>true)));
};

$return = array();
switch($action){
    case "getSavedPic":
        $data = getSavedPic($user);
        $return["success"] = true;
        $return["data"] = $data;
        break;
    default:
        $return['success']=false;
}
die(json_encode($return));


function getSavedPic( $user ){
    $userDir = sprintf('persistent/user/%s', $user);
    if( !file_exists($userDir)){
        return false;
    }
    $userSaveFile = $userDir . '/save.txt';
    if( !file_exists($userSaveFile)){
        return false;
    }

    return file_get_contents($userSaveFile);
}
