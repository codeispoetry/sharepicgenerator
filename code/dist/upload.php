<?php

require_once('lib/functions.php');
require_once('lib/upload_functions.php');

$id = $_POST['id'];

$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

if (isset($_FILES['file']) && !isFileAllowed($extension, array('jpg','jpeg','png','gif','svg','webp','mp4','zip'))) {
    echo json_encode(array("error"=>"wrong fileformat"));
    die();
}

switch ($id) {
    case "uploadfile":
        if ($extension == 'mp4') {
            handleVideoUpload();
        }
        handleBackgroundUpload();
        break;

    case "uploadlogo":
        handleLogoUpload();
        break;
    case "uploadicon":
        handleIconUpload();
        break;
    case "uploadbyurl":
        handleUploadByUrl();
        break;
    case "uploadaddpic1":
    case "uploadaddpic2":
        handleAddPicUpload();
        break;
    case "uploadwork":
        handleUploadWork();
        break;
    default:
        echo json_encode(array("error"=>"nothing done. id=" . $id));
        die();
}
