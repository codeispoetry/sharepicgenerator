<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));
useDeLocale();

session_start();

if (!isAllowed(true)) {
    returnJsonErrorAndDie('not allowed');
}

deleteUserLogo(getUser());
