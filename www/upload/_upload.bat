@ECHO OFF

ECHO Uploading to %CAESAR_LOGIN%@%CAESAR_FTP%...
ECHO.

pscp all.tar.gz %CAESAR_LOGIN%@%CAESAR_FTP%:www/caesar/upload/all.tar.gz

rm -f all.tar.gz

ECHO.
PAUSE