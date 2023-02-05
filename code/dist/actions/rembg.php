<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
useLocale('de_DE');

session_start();

if (!isAllowed(true)) {
    die("not allowed");
}

$filename = substr($_POST['filename'], 1, -1);

$new_filename = $filename . '.rembg.png';

$command = sprintf(
    "NUMBA_CACHE_DIR=/tmp rembg i -m u2net_human_seg %s %s 2>&1",
    $filename,
    $new_filename
);

exec($command);

echo json_encode(['filename' => $new_filename]);
