<?php

require_once('base.php');
require_once('lib/functions.php');
require_once('lib/log_functions.php');

$db = new SQLite3(getBasePath('log/logs/log.db'));

// delete tmp-files
deleteFilesInPathOlderThanHours(getBasePath('tmp/*'), null, 2 * 24);
deleteFilesInPathOlderThanHours(getBasePath('tmp/*.mp4'), null, 6);
deleteFilesInPathOlderThanHours(getBasePath('tmp/*.zip'), null, 6);
deleteFilesInPathOlderThanHours(getBasePath('tmp/qrcode_*'), null, 2);
deleteFilesInPathOlderThanHours(getBasePath('tmp/work*'), null, 6);
deleteFilesInPathOlderThanHours(getBasePath('tmp/fonts/*'), null, 6);



$db->query(
    'DELETE FROM "qrcode" WHERE timestamp <= date("now", "-1 day")'
);

$db->query(
    'DELETE FROM "mail" WHERE timestamp <= date("now", "-1 day")'
);
