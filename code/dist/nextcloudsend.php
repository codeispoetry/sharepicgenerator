<?php
require_once('functions.php');
//curl -X  \
//MKCOL 'https://wolke.netzbegruenung.de/remote.php/dav/files/ThomasPf/sharepicgenerator' \
//-u ThomasPf:YFGrq-jCeyt-Byid9-4cdcZ-CfPtp

if( !isAllowed() ){
    die( isAllowed() );
}


$filename = sprintf('../tmp/%s.jpg', sanitize_userinput($_POST['file']));
$remoteFile = $_POST['downloadname'] ?: 'sharepic';
$user = getUser();
$cloudtoken = getCloudToken( );

$user = "ThomasPf";
$payload     = sprintf('--data-binary @"%s" ', $filename );
$credentials = sprintf('-u %s:%s', $user, $cloudtoken );
$endpoint    = sprintf("PUT 'https://wolke.netzbegruenung.de/remote.php/dav/files/%s/sharepicgenerator/%s.jpg'", $user, $remoteFile);

$command = sprintf('curl -X %s %s %s',
    $endpoint,
    $payload,
    $credentials
);

exec( $command, $debug);

echo json_encode( array(
    "status" => 200
    )
);

