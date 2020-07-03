<?php
require_once('functions.php');

if( !isAllowed() ){
    die(  );
}


$credentials = sprintf('-u %s', getCloudCredentials() );
$payload = '';
$endpoint = sprintf("PROPFIND 'https://wolke.netzbegruenung.de/remote.php/dav/files/%s/sharepicgenerator'", getUserFromCloudCredentials( ), $remoteFile);


$command = sprintf('curl -X %s %s %s',
    $endpoint,
    $payload,
    $credentials
);

exec( $command, $output);

$files = xml2json( join('', $output));


echo json_encode( array(
    "status" => 200,
    "data" => $files
    )
);



function xml2json( $xml ){
    $xml = preg_replace('/d\:/','', $xml);

    $xml = simplexml_load_string( $xml);
    $json = json_encode($xml);
    $array = json_decode($json,FALSE);

    // the first item is the directory, skip it
    array_shift( $array->response);

    $return = array();
    foreach($array->response AS $file ){
        if( strToLower(pathinfo($file->href, PATHINFO_EXTENSION)) == 'zip') {
            $return[] = $file->href;
        }
    }

    return $return;
}