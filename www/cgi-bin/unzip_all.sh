#!/usr/bin/env sh

WWW=/home/lac/www/caesar

cd $WWW
unzip -o upload/all.zip
RESULT=$?

echo
echo Error code=$RESULT

