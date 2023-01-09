<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/mail_functions.php'));
useDeLocale();

$recipient = 'mail@tom-rose.de';
$file = false;
$text = 'SAML is back';

email($recipient, $file, $text);
