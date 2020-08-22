<?php

/**
 * @deprecated deprecated
 */
function deleteSavedPic($user)
{
    $userDir = sprintf('persistent/user/%s', $user);
    $userSaveFile = $userDir . '/save.txt';

    $json = json_decode(file_get_contents($userSaveFile));
    $file = $json->fullBackgroundName;
    if (file_exists($file)) {
        unlink($file);
    }

    if (file_exists($userSaveFile)) {
        unlink($userSaveFile);
    }
}

/**
 * @deprecated deprecated
 */
function savePic($user, $data)
{
    $userDir = sprintf('persistent/user/%s', $user);
    if (!file_exists($userDir)) {
        mkdir($userDir);
    }
    $userSaveFile = $userDir . '/save.txt';

    $params = array();
    parse_str($data, $params);

    // save uploaded image persistent
    if (is_file($params['fullBackgroundName'])) {
        $new_name = $userDir . '/' . basename($params['fullBackgroundName']);
        copy($params['fullBackgroundName'], $new_name);
        $params['fullBackgroundName'] = $new_name;
    }

    // save uploaded icon persistent
    if (is_file($params['fullBackgroundName'])) {
        $new_name = $userDir . '/' . basename($params['fullBackgroundName']);
        copy($params['fullBackgroundName'], $new_name);
        $params['fullBackgroundName'] = $new_name;
    }

    file_put_contents($userSaveFile, json_encode($params));
    return true;
}
