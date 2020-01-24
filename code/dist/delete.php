<?php

require_once( 'functions.php');

if( !isAllowed() ) {
    returnJsonErrorAndDie('not allowed');
}

deleteUserLogo( getUser() );




function deleteUserLogo( $user ){

    $userDir = 'persistent/user/' . $user;
    if( !file_exists($userDir)){
        return;
    }

    $logos = glob(sprintf('%s/logo.*', $userDir));
    array_walk( $logos, function(&$file){ unlink($file);});

}
