<?php

setlocale (LC_ALL, ' de_DE.UTF-8','de_DE.utf8');

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

function getCloudCredentials( ){
    $tokenfile = getUserDir() .'/.cloudcredentials.txt';

    if( !file_exists( $tokenfile ) ){
        return false;
    }
    return file_get_contents( $tokenfile );
}

function getUserFromCloudCredentials(  ){
    list($user, $token) = explode( ':', getCloudCredentials());
    return $user;
}


function getUserDir(){
  $userDir = 'persistent/user/' . getUser();
  if( !file_exists( $userDir ) ){
      return false;
  }

  return $userDir;
}

function hasCloudCredentials(){
    global $user;
    $cloudTokenFile = sprintf('../../persistent/user/%s/.cloudcredentials.txt', $user) ;
    return file_exists( $cloudTokenFile );
}

function returnJsonErrorAndDie( $code = 1){
    echo json_encode(array('success'=>'false','error'=>array('code'=>$code)));
    die();
}


function returnJsonSuccessAndDie(){
    echo json_encode(array('success'=>'true'));
    die();
}


function logthis(){
    global $user, $landesverband, $tenant;
    $line = sprintf("%s\t%s\t%s\t%s\t%s\n", time(), $user, "login", $landesverband, $tenant );
    file_put_contents('../../log/log.log', $line, FILE_APPEND);
}


function isLocal(){
    $GLOBALS['user'] = "localaccessed";
    return ($_SERVER['REMOTE_ADDR'] == '127.0.0.1');
}


function createAccessToken( $user ){
    $userDir = '../../persistent/user/' . $user;
    if( !file_exists($userDir)){
        mkdir( $userDir );
    }

    $accessToken = uniqid();
    file_put_contents( sprintf('%s/accesstoken.php',$userDir), $accessToken);
    return $accessToken;
}


function isLocalUser(){
    $GLOBALS['user'] = "localuser";
    if( !isset($_POST['pass'])){
        return false;
    }

    if( !file_exists('../../passwords.php')){
        return false;
    }


    if( !loginAttemptsLeft() ){
        die("Bitte warten. Zu viele Fehlversuche");
    }

    require_once('../../passwords.php');
    if( in_array($_POST['pass'], $passwords)){
        return true;
    }

    increaseLoginAttempts();

    die("Passwort falsch");
    return false;
}


function increaseLoginAttempts(){
    $file = '../../loginattempts.txt';
    if( file_exists( $file ) ){
        $attempts = file_get_contents( $file );
        $attempts++;
    }else{
        $attempts = 1;
    }

    file_put_contents( $file, $attempts );
}


function loginAttemptsLeft(){
    $file = '../../loginattempts.txt';

    if( !file_exists( $file ) ){
        return true;
    }

    if( time() - filemtime( $file ) > 5 * 60 ){
        unlink( $file );
        return true;
    }

    $attempts = file_get_contents( $file );

    if( $attempts < 5 ){
        return true;
    }

    return false;
}


function isDaysBefore($dayMonth, $days = 14 ){
    $day = new DateTime(sprintf('%s%d 23:59:59', $dayMonth, date('Y'))); // tag.monat.jahr
    $today = new DateTime();
    $interval = $day->diff($today);

    return ( $interval->days < $days AND $interval->invert == 1);
}


function checkPermission( $user, $accesstoken){
    $userDir = 'persistent/user/' . $user;
    if( !file_exists($userDir)){
        return false;
    }

    return ( file_get_contents( sprintf('%s/accesstoken.php',$userDir)) == $accesstoken);
}



function sanitize_userinput($var)
{
    return preg_replace('/[^a-zA-Z0-9\.]/', '', $var);
}
