<?php
$line = sprintf("%s\t%s\t%s\n", time(), $user, "login" );
file_put_contents('log/log.log', $line, FILE_APPEND);