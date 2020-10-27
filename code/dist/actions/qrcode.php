<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
$file = sprintf('tmp/%s.jpg', sanitizeUserinput($_GET['f']));

header('Content-Type: image/jpg');
header("Content-Length: ".filesize($file));
header('Content-Disposition: attachment; filename="sharepic.jpg"');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
readfile($file);
