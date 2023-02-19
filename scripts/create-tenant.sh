cp -r code/dist/tenants/cockpit/$2 code/dist/tenants/cockpit/$1
cp -r code/build/js/$2 code/build/js/$1

make compile

#sed -i "s/btw21/$1/g" code/dist/tenants/$1/index.php
#sed -i "s/btw21/$1/g" code/dist/tenants/$1/log/index.php
