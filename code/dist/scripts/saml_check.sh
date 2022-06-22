#!/bin/bash
if /usr/bin/curl -I "https://saml.gruene.de" 2>&1 | grep -w "Failed" ; then
    rm /var/www/sharepicgenerator.de/shared/scripts/saml_is_up
else
    touch /var/www/sharepicgenerator.de/shared/scripts/saml_is_up
    php /var/www/sharepicgenerator.de/current/actions/notify.php
fi