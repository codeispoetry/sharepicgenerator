<?php

require_once('base.php');
require_once(getBasePath('lib/functions.php'));

if (!isAllowed()) {
    returnJsonErrorAndDie('not allowed');
}

deleteUserLogo(getUser());
