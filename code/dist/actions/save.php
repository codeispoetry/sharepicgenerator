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
    $file_number = 1;
    $dir = getBasePath('persistent/user/' . getUser());
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    $file = sprintf('%s/sharepic%d.json', $dir, $file_number);

    $sharepic = $_POST['sharepic'];

    parse_str($sharepic, $vars);

    $background = $vars['fullBackgroundName'];
    $target = sprintf('%s/sharepic%d.%s', $dir, $file_number, pathinfo($background, PATHINFO_EXTENSION));

    if (file_exists($background)) {
        copy($background, $target);
    }

    $vars['fullBackgroundName'] = $target;
    $content = json_encode($vars);

    file_put_contents($file, $content);
}
