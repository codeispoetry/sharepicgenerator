<?php

$command = escapeshellcmd('./api.py');
$output = shell_exec($command);
echo $output;
