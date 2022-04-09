<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));

useDeLocale();

session_start();

if (!isset($_POST['q'])) {
    returnJsonErrorAndDie('no query given');
}

if (!isAllowed(false)) {
    returnJsonErrorAndDie('not allowed');
}

$q = sanitizeUserInput($_POST['q']);
$apikey = configValue('Unsplash', 'accesskey');
$perPage = 80;

$cmd = sprintf('curl -H "Authorization: Client-ID %s"   "https://api.unsplash.com/search/photos?query=%s&lang=de&per_page=%s"', $apikey, $q, $perPage);

exec($cmd, $output);

$data = json_decode($output[0]);
if (isset($data->errors)) {
    returnJsonErrorAndDie('api error');
}

echo $output[0];
