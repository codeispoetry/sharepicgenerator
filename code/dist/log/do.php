<?php
$line = sprintf("%s\t%s\t%s\t%s\n", time(), $user, "login", $landesverband );
file_put_contents('log/log.log', $line, FILE_APPEND);