<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/save_functions.php'));
useDeLocale();

session_start();

if (!isAllowed(true)) {
    die();
}

$user = $_SESSION['user'];
$action = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['action']);
$data = $_POST['data'];

$return = array();

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
