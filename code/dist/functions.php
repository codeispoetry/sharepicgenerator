<?php




function isAllowed( ){

    if( !isset($_POST['accesstoken'] )) return false;
    $accesstoken = preg_replace('/[^a-zA-Z0-9]/','', $_POST['accesstoken']);

    $user = getUser();

    $userDir = 'persistent/user/' . $user;
    if( !file_exists($userDir)){
        return false;
    }

    return ( file_get_contents( sprintf('%s/accesstoken.php',$userDir)) == $accesstoken);
}


function getUser(){
    if( !isset($_POST['user'] )) return false;
    $user = preg_replace('/[^a-zA-Z0-9]/','', $_POST['user']);
    return $user;
}

function getUserDir(){
  $userDir = 'persistent/user/' . getUser();
  if( !file_exists( $userDir ) ){
      return false;
  }

  return $userDir;
}


function returnJsonErrorAndDie( $code = 1){
    echo json_encode(array('success'=>'false','error'=>array('code'=>$code)));
    die();
}
