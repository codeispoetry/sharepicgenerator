<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/gallery_functions.php'));

useDeLocale();

session_start();

if (!isset($_POST['q'])) {
    returnJsonErrorAndDie('no query given');
}

if (!isAllowed(false)) {
    returnJsonErrorAndDie('not allowed');
}

$q = sanitizeUserInput($_POST['q']);
$apikey = configValue('Pexels', 'apikey');
$perPage = 80;

$cmd = sprintf('curl -H "Authorization: %s"   "https://api.pexels.com/v1/search?query=%s&per_page=%s"', $apikey, $q, $perPage);

exec($cmd, $output);
if (isset($output[1])) {
    returnJsonErrorAndDie('api error');
}
echo $output[0];
