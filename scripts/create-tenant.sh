cp -r code/dist/tenants/btw21 code/dist/tenants/$1
cp -r code/build/js/btw21 code/build/js/$1
cp  code/webpack.tenants/btw21.js  code/webpack.tenants/$1.js

sed -i "s/btw21/$1/g" code/webpack.tenants/$1.js
sed -i "s/btw21/$1/g" code/dist/tenants/$1/index.php
sed -i "s/btw21/$1/g" code/dist/tenants/$1/log/index.php

