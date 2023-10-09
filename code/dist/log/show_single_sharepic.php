<?php

require_once 'base.php';
require_once getBasePath( 'lib/functions.php' );
require_once getBasePath( 'lib/log_show_functions.php' );

$id = $_GET['id'];

$row = getSingleSharepic( $id );
echo '<pre>';
print_r( $row );
echo '</pre>';

$dir        = '../tmp/';
$logpicture = $dir . 'log_' . $id . '.jpg';
$svg        = $dir . $id . '.svg';

printf( '<a href="%s">Zur SVG-Datei</a><br>', $svg );
printf( '<img src="%s">', $logpicture );
printf( '<br>Background<br><img src="%s">', $dir . $row['backgroundURL'] );
