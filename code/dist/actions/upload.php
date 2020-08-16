<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/upload_functions.php'));

$id = $_POST['id'];

$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

if (isset($_FILES['file']) && !isFileAllowed($extension, array('jpg','jpeg','png','gif','svg','webp','mp4','zip'))) {
    echo json_encode(array("error"=>"wrong fileformat"));
    die();
}

switch ($id) {
    case "uploadfile":
        if ($extension == 'mp4') {
            handleVideoUpload($extension);
        }
        handleBackgroundUpload($extension);
        break;

    case "uploadlogo":
        handleLogoUpload($extension);
        break;
    case "uploadicon":
        handleIconUpload($extension);
        break;
    case "uploadbyurl":
        handleUploadByUrl();
        break;
    case "uploadaddpic1":
    case "uploadaddpic2":
        handleAddPicUpload($extension);
        break;
    case "uploadwork":
        handleUploadWork();
        break;
    default:
        echo json_encode(array("error"=>"nothing done. id=" . $id));
        die();
}
