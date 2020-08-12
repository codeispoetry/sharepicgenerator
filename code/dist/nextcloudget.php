<?php
require_once('lib/functions.php');

if( !isAllowed() ){
    die(  );
}

$credentials = sprintf('-u %s', getCloudCredentials() );

if( $_POST['mode'] == 'file'){
    $filebasename = 'tmp/' . uniqid('workfromcloud');
    $zipfilename = $filebasename . '.zip';

    $payload = '';
    $destinationFile = 'tmp/' . uniqid('workfromcloud', true) . '.zip';
    $endpoint = sprintf("GET 'https://wolke.netzbegruenung.de%s' --output %s",  $_POST['file'], $zipfilename );
}else {
    $payload = '';
    $endpoint = sprintf("PROPFIND 'https://wolke.netzbegruenung.de/remote.php/dav/files/%s/sharepicgenerator'", getUserFromCloudCredentials());
}

$command = sprintf('curl -X %s %s %s',
    $endpoint,
    $payload,
    $credentials
);

exec( $command, $output);

if( $_POST['mode'] == 'file'){
    $savedir = 'tmp/' . basename( $zipfilename,  '.zip' );
    $cmd = sprintf('unzip %s -d %s 2>&1', $zipfilename, $savedir );
    exec( $cmd, $output );

    $return['okay'] = true;
   // $return['debug'] = $cmd;

    $datafile = $savedir . '/data.json';
    $json = file_get_contents( $datafile );


    $return['data'] = $json;
    $return['dir'] = $savedir;

    echo json_encode($return);
}else {
    if(empty($output)){
        echo json_encode( array(
                "status" => 501,
                "data" => "Access denied"
            )
        );
        die();
    }

    $files = xml2json(join('', $output));
    echo json_encode( array(
            "status" => 200,
            "data" => $files
        )
    );
}

function xml2json( $xml ){
    $xml = preg_replace('/d\:/','', $xml);

    $xml = simplexml_load_string( $xml);
    $json = json_encode($xml);
    $array = json_decode($json,FALSE);

    if(is_null($array->response)){
        echo json_encode( array(
                "status" => 502,
                "data" => "Access denied"
            )
        );
        die();
    }

    if(!is_array($array->response)){
        return array();
    }

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
