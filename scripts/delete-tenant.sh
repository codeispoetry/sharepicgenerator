if [ ! -d code/dist/tenants/cockpit/$1 ]
then
  echo $1 does not exist. Abort
  exit
fi

rm -rf code/dist/tenants/cockpit/$1
rm -rf code/build/js/$1
rm -rf code/dist/assets/$1

echo The tenant has been deleted.
