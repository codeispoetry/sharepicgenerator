<?php

function do_saml_login()
{

    return 'ohne_saml';

    $hasAccess = isLocal() ?: isLocalUser();

    $doLogout = false;
    if (isset($_GET['logout']) && ($_GET['logout'] == 'true')) {
        if ($hasAccess) {
            doLogout();
        } else {
            $doLogout = true;
            handleSamlAuth($doLogout);
        }
        die();
    }

    if (!$hasAccess) {
        $user = handleSamlAuth($doLogout);
    }

    return $user;
}