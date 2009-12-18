@ECHO OFF

ECHO Uploading to %CAESAR_LOGIN%@%CAESAR_FTP%...
ECHO.

pscp all.zip %CAESAR_LOGIN%@%CAESAR_FTP%:www/caesar/upload/all.zip

rm -f all.zip

ECHO.
PAUSE
