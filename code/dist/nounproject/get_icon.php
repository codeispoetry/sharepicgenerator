<?php

if( !isset($_GET['icon_url'])){
    die();
}

$icon_url = $_GET['icon_url'];

sanitize_user_input( $icon_url );


$iconfilename = uniqid('icon_') . '.svg';
$remote = urldecode( $icon_url );
copy( $remote, '../tmp/' . $iconfilename);
make_white( '../tmp/' . $iconfilename );
die( $iconfilename );




function make_white( $file ){
    $svg = join("\n",file( $file ));

	$svg = preg_replace('/fill=/','nofill=', $svg);

    $svg = preg_replace('/<path /','<path fill="white" ', $svg);
    $svg = preg_replace('/<circle /','<circle fill="white" ', $svg);
    $svg = preg_replace('/<rect /','<rect fill="white" ', $svg);
    $svg = preg_replace('/<polygon /','<polygon fill="white" ', $svg);
    $svg = preg_replace('/<polyline /','<polygon fill="white" ', $svg);
    $fp = fopen( $file, 'w');
        fwrite( $fp, $svg );
    fclose( $fp );
}   


function sanitize_user_input( $input ){
    $host = parse_url( $input, PHP_URL_HOST );
    if( $host != 'static.thenounproject.com'){
        die("error");
    }
}

?>