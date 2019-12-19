<?php
if (!file_exists('../config.ini')) { 
    die(); 
}
$keys = parse_ini_file('../config.ini', TRUE);

( isset($_GET['q'] ) ) ? $q = $_GET['q'] : die();


require_once 'TheNounProject.class.php';
$key  = $keys["NounProject"]["key"];
$secret = $keys["NounProject"]["secret"];
$theNounProject = new TheNounProject($key, $secret, true);
$icons = $theNounProject->getIconsByTerm(
    $q,
    array('limit' => 50, 'limit_to_public_domain' => 1 )
);

if( empty($icons) ){
    echo json_encode( array("error" => "no_results", "hits"=>[] ) );
}else{
    echo json_encode( array("hits" => $icons ));
}


