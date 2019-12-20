<?php

$command = escapeshellcmd("python api.py --text $'" . urldecode($_GET['text']) . "'");
$output = shell_exec($command);

?>

<img src="sharepic.png">
