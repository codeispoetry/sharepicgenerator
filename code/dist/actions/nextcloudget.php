<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));

if (!isAllowed()) {
    die();
}

$credentials = sprintf('-u %s', getCloudCredentials());

if ($_POST['mode'] == 'file') {
    $filebasename = getBasePath('tmp/' . uniqid('workfromcloud'));
    $zipfilename = $filebasename . '.zip';

    $payload = '';
    $destinationFile = getBasePath('tmp/' . uniqid('workfromcloud', true) . '.zip');
    $endpoint = sprintf("GET 'https://wolke.netzbegruenung.de%s' --output %s", $_POST['file'], $zipfilename);
} else {
    $payload = '';
    $endpoint = sprintf(
        "PROPFIND 'https://wolke.netzbegruenung.de/remote.php/dav/files/%s/sharepicgenerator'",
        getUserFromCloudCredentials()
    );
}

$command = sprintf(
    'curl -X %s %s %s',
    $endpoint,
    $payload,
    $credentials
);

exec($command, $output);

if ($_POST['mode'] == 'file') {
    $savedir = getBasePath('tmp/' . basename($zipfilename, '.zip'));
    $cmd = sprintf('unzip %s -d %s 2>&1', $zipfilename, $savedir);
    exec($cmd, $output);

    $return['okay'] = true;
    // $return['debug'] = $cmd;

    $datafile = $savedir . '/data.json';
    $json = file_get_contents($datafile);

    $return['data'] = $json;
    $return['dir'] = $savedir;

    echo json_encode($return);
} else {
    if (empty($output)) {
        echo json_encode(
            array(
                "status" => 501,
                "data" => "Access denied"
            )
        );
        die();
    }

    $files = xml2json(join('', $output));
    echo json_encode(
        array(
            "status" => 200,
            "data" => $files
        )
    );
}
