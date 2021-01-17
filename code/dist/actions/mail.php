<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/mail_functions.php'));
useDeLocale();

session_start();

if (!isAllowed()) {
    die();
}

$file = getBasePath('tmp/' . sanitizeUserinput($_POST['file']));
$recipient = $_POST['recipient'];
$text = $_POST['text'];


email($recipient, $file, $text);
