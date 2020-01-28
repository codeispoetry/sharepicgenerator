<?php

if( !isset($_POST['user'] )) die();
if( !isset($_POST['accesstoken'] )) die();


$user = preg_replace('/[^a-zA-Z0-9]/','', $_POST['user']);
$accesstoken = preg_replace('/[^a-zA-Z0-9]/','', $_POST['accesstoken']);
$data = $_POST['data'];

$return = array();

if( !checkPermission( $user, $accesstoken )){
    die('-1');
};

if( savePic( $user, $data )){
    $return['success'] = true;
    die(json_encode($return));
}



function checkPermission( $user, $accesstoken){
    $userDir = 'persistent/user/' . $user;
    if( !file_exists($userDir)){
        return false;
    }

    return ( file_get_contents( sprintf('%s/accesstoken.php',$userDir)) == $accesstoken);
}




function savePic( $user, $data ){

    $userDir = sprintf('persistent/user/%s', $user);
    if( !file_exists($userDir)){
        mkdir( $userDir );
    }
    $userSaveFile = $userDir . '/save.txt';

    $params = array();
    parse_str($data, $params);

    // save uploaded image persisten
    $new_name = $userDir .'/' . basename($params['fullBackgroundName']);
    copy($params['fullBackgroundName'], $new_name);
    $params['fullBackgroundName'] = $new_name;

    file_put_contents($userSaveFile, json_encode($params));
    return true;
}
