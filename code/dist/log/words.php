<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
require_once(getBasePath('lib/log_functions.php'));

setlocale(LC_TIME, ' de_DE.UTF-8', 'de_DE.utf8');
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="theme-color" content="#46962b">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logs</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
</head>
<body>
<?php

print_r(wordCounts(7));

?>
</body>
</html>
