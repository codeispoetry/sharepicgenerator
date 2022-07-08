if [ ! -d code/dist/tenants/$1 ]
then
  echo $1 existiert nicht. Abbruch.
  exit
fi

rm -rf code/dist/tenants/$1
rm -rf code/build/js/$1
rm code/webpack.tenants/$1.js

echo $i wurde gelöscht.
