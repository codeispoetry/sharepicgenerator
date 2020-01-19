<?php

if( !isset($_POST['user'] )) die();
if( !isset($_POST['accesstoken'] )) die();


$user = preg_replace('/[^a-zA-Z0-9]/','', $_POST['user']);
$accesstoken = preg_replace('/[^a-zA-Z0-9]/','', $_POST['accesstoken']);

if( !checkPermission( $user, $accesstoken )){
    die('-1');
};

deleteUserLogo( $user );



function checkPermission( $user, $accesstoken){
    $userDir = 'persistent/user/' . $user;
    if( !file_exists($userDir)){
        return false;
    }

    return ( file_get_contents( sprintf('%s/accesstoken.php',$userDir)) == $accesstoken);
}




function deleteUserLogo( $user ){

    $userDir = 'persistent/user/' . $user;
    if( !file_exists($userDir)){
        return;
    }

    $logos = glob(sprintf('%s/logo.*', $userDir));
    array_walk( $logos, function(&$file){ unlink($file);});

}
