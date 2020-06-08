<?php

require_once('functions.php');

if( !isset($_POST['user'] )) die();
if( !isset($_POST['accesstoken'] )) die();

$user = preg_replace('/[^a-zA-Z0-9]/','', $_POST['user']);
$accesstoken = preg_replace('/[^a-zA-Z0-9]/','', $_POST['accesstoken']);
$action = preg_replace('/[^a-zA-Z0-9]/','', $_POST['action']);
$data = $_POST['data'];

$return = array();

if( !checkPermission( $user, $accesstoken )){
    die('-1');
};

switch( $action ){
    case 'save':
        if( savePic( $user, $data )){
            $return['success'] = true;
            die(json_encode($return));
        }
        break;
    case 'delete':
        deleteSavedPic( $user );
        break;
    default:
        $return['success'] = false;
        die(json_encode($return));

}


function deleteSavedPic( $user ){
    $userDir = sprintf('persistent/user/%s', $user);
    $userSaveFile = $userDir . '/save.txt';

    $json = json_decode(file_get_contents($userSaveFile));
    $file = $json->fullBackgroundName;
    if( file_exists($file)){
        unlink($file);
    }

    if( file_exists($userSaveFile)){
        unlink($userSaveFile);
    }
}


function savePic( $user, $data ){

    $userDir = sprintf('persistent/user/%s', $user);
    if( !file_exists($userDir)){
        mkdir( $userDir );
    }
    $userSaveFile = $userDir . '/save.txt';

    $params = array();
    parse_str($data, $params);

    // save uploaded image persistent
    if( is_file($params['fullBackgroundName']) ) {
        $new_name = $userDir . '/' . basename($params['fullBackgroundName']);
        copy($params['fullBackgroundName'], $new_name);
        $params['fullBackgroundName'] = $new_name;
    }

    // save uploaded icon persistent
    if( is_file($params['fullBackgroundName']) ) {
        $new_name = $userDir . '/' . basename($params['fullBackgroundName']);
        copy($params['fullBackgroundName'], $new_name);
        $params['fullBackgroundName'] = $new_name;
    }

    file_put_contents($userSaveFile, json_encode($params));
    return true;
}
