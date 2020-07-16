<?php


if (isset($as) ) {
    $attributes = $as->getAttributes();
    $landesverband = (int) substr($attributes['membershipOrganizationKey'][0], 1, 2);

    if ($landesverband == 5 AND isset($_SERVER['HTTP_REFERER'])) {
        if ('saml.gruene.de' == parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST)) {
            // freshly logged in
            header('Location: /nrw', true, 302);
            die();
        }
    }
}
