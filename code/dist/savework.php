<?php
$basename = uniqid('save');
$filename = 'tmp/' . $basename . '.ser';

$data = $_POST['data'];

file_put_contents( $filename, $data );

$backgroundfile = 'federal/templates/annalena.jpg';

$command = sprintf('zip -j tmp/%s.zip %s %s 2>&1', $basename, $filename, $backgroundfile);
exec( $command );

$return = array(
    "status" => 200,
    "basename" => $basename
);

echo json_encode( $return );