<?php

require_once('lib/functions.php');

if (!isAllowed()) {
    die();
}

// send file
$filename = sprintf('tmp/%s', sanitizeUserInput($_POST['file']));
$remoteFile = $_POST['downloadname'] ?: 'sharepic';

$payload = sprintf('--data-binary @"%s" ', $filename);
$endpoint = sprintf(
    "PUT 'https://wolke.netzbegruenung.de/remote.php/dav/files/%s/sharepicgenerator/%s'",
    getUserFromCloudCredentials(),
    $remoteFile
);
$credentials = '-u ' . getCloudCredentials();

$command = sprintf(
    'curl -X %s %s %s',
    $endpoint,
    $payload,
    $credentials
);

exec($command, $debug);

echo json_encode(
    array(
    "status" => 200,
    "command" => $command,
    "debug" => join('', $debug)
    )
);
