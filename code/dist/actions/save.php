<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/user_functions.php'));
useLocale('de_DE');

session_start();

if (!isAllowed()) {
    die();
}

save();

$return = ["code" => 0];
echo json_encode($return);


function save()
{
    $dir = getBasePath('persistent/user/' . getUser());
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    $file = $dir . '/sharepic.json';

    $sharepic = $_POST['sharepic'];

    parse_str($sharepic, $vars);

    $content = json_encode($vars);

    file_put_contents($file, $content);
}
