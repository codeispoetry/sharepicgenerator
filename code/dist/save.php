<?php

require_once('base.php');
require_once('lib/functions.php');
require_once('lib/save_functions.php');

if (!isset($_POST['user'])) {
    die();
}
if (!isset($_POST['accesstoken'])) {
    die();
}

$user = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['user']);
$accesstoken = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['accesstoken']);
$action = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['action']);
$data = $_POST['data'];

$return = array();

if (!checkPermission($user, $accesstoken)) {
    die('-1');
};

switch ($action) {
    case 'save':
        if (savePic($user, $data)) {
            $return['success'] = true;
            die(json_encode($return));
        }
        break;
    case 'delete':
        deleteSavedPic($user);
        break;
    case 'saveCloudToken':
        saveCloudToken();
        break;
    case 'deleteCloudToken':
        deleteCloudToken();
        break;
    default:
        $return['success'] = false;
        die(json_encode($return));
}
