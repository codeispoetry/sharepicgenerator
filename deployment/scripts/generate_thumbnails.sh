#!/bin/bash
set -e

DIR=$1
EXTENSIONS="jpg JPG jpeg JPEG png PNG"

for d in $(find $DIR -maxdepth 1 -mindepth 1 -type d); do
  pushd $d >/dev/null

  if [ ! -d thumbs ]; then
    mkdir thumbs
  fi

  for ext in $EXTENSIONS; do
    SAVEIFS=$IFS
    IFS=$(echo -en "\n\b")
    for f in $(ls -1 *.${ext} 2>/dev/null); do
      echo $f
      if [ ! -f "thumbs/${f}" ]; then
        convert $f -background white -flatten -resize 800x800 -quality 75 "thumbs/${f}";
      fi
    done
    IFS=$SAVEIFS
  done

  popd >/dev/null
done
