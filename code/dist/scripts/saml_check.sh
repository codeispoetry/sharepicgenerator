#!/bin/bash
if /usr/bin/curl -I "https://saml.gruene.de" 2>&1 | grep -w "Failed" ; then
    touch /var/www/sharepicgenerator.de/shared/scripts/saml_is_down
else
    rm /var/www/sharepicgenerator.de/shared/scripts/saml_is_down
fi