<?php

if( !isset($_POST['user'] )) die();

$user = preg_replace('/[^a-zA-Z0-9]/','', $_POST['user']);

deleteUserLogo( $user );

function deleteUserLogo( $user ){

    $userDir = 'persistent/user/' . $user;
    if( !file_exists($userDir)){
        return;
    }

    $logos = glob(sprintf('%s/logo.*', $userDir));
    array_walk( $logos, function(&$file){ unlink($file);});

}
