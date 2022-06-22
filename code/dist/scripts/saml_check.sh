#!/bin/bash
if /usr/bin/curl -I "https://saml.gruene.de" 2>&1 | grep -w "200\|301" ; then
  touch /var/www/sharepicgenerator.de/shared/scripts/status/saml_is_up
  php /var/www/sharepicgenerator.de/current/actions/notify.php
else
    rm /var/www/sharepicgenerator.de/shared/scripts/status/saml_is_up
fi