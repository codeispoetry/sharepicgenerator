<?php
$line = sprintf("%s\t%s\t%s\n", time(), $user, "login" );
file_put_contents('log/log.txt', $line, FILE_APPEND);