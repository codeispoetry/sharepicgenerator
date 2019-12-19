<?php

$command = escapeshellcmd('./api.py --text "' . urldecode($_GET['text']) . '"');
$output = shell_exec($command);
echo $output;
