<?php
if (isset($as) ) {
    $samlattributes = $as->getAttributes();
    $user = md5($samlattributes['urn:oid:0.9.2342.19200300.100.1.1'][0]);
}else{
    $user="generic";
}
$line = sprintf("%s\t%s\t%s\n", time(), $user, "login" );
file_put_contents('log/log.txt', $line, FILE_APPEND);