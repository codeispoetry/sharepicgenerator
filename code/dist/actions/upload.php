<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/upload_functions.php'));
useLocale('de_DE');

session_start();

if (!isAllowed()) {
    die();
}

$id = $_POST['id'];

if (isset($_FILES['file']) ) {
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
}
if (isset($_FILES['file']) && !isFileAllowed($extension, array('jpg','jpeg','png','heic','gif','svg','webp','mp4','zip','ttf','otf'))) {
    echo json_encode(array("error"=>"wrong fileformat"));
    die();
}

switch ($id) {
    case "uploadfile":
        handleBackgroundUpload($extension);
        break;

    case "uploadlogo":
        handleLogoUpload($extension);
        break;
    case "uploadtmplogo":
        handleTmpLogoUpload($extension);
        break;
    case "uploadfont":
        handleFontUpload($extension);
        break;
    case "uploadicon":
        handleIconUpload($extension);
        break;
    case "uploadbyurl":
        handleUploadByUrl();
        break;
    case "uploadaddpic1":
    case "uploadaddpic2":
    case "uploadaddpic3":
    case "uploadaddpic4":
    case "uploadaddpic5":
        handleAddPicUpload($extension);
        break;
    case "uploadwork":
        handleUploadWork();
        break;
    default:
        echo json_encode(array("error"=>"nothing done. id=" . $id));
        die();
}
