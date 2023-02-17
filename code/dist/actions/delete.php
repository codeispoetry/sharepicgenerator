<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/upload_functions.php'));
require_once(getBasePath('lib/user_functions.php'));
useLocale('de_DE');

session_start();

if (!isAllowed()) {
    die();
}

delete();

$return = ["code" => 0];
echo json_encode($return);


function delete()
{

    $file_number = 1;
    $dir = getBasePath('persistent/user/' . getUser());

    $config = json_decode($_POST['config']);
    
    $file = sprintf('%s/%s_sharepic%d.json', $dir, $config->tenant, $file_number);

    if (!file_exists($file)) {
        return;
    }
    unlink($file);
}
