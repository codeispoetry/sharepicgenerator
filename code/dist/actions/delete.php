<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/gallery_functions.php'));

useDeLocale();

session_start();

if (!isset($_POST['action'])) {
    returnJsonErrorAndDie('no action given');
}

if (!isAllowed(true)) {
    returnJsonErrorAndDie('not allowed');
}

switch ($_POST['action']) {
    case 'logo':
        deleteUserLogo(getUser());
        break;
    case 'workfile':
        deleteWorkfile($_POST['workfileiId']);
        break;
    default:
        returnJsonErrorAndDie('unknown action');
}
