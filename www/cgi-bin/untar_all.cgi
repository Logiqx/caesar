#!/bin/sh

HOME=/home2/lac/www/caesar
UPLOAD=$HOME/upload

cd $HOME

echo "Content-type: text/html"
echo

echo "<html><body><pre>"
date
echo

tar -x -v -b20 -f${UPLOAD}/all.tar.gz -z

RESULT=$?

echo
echo Error code=$RESULT

echo
date
echo "</pre></body></head>"
