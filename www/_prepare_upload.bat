@ECHO OFF

IF NOT EXIST %CAESAR%\www\upload MKDIR %CAESAR%\www\upload
IF NOT EXIST %CAESAR%\www\upload\all.tar.gz GOTO MAKE_TAR

DEL %CAESAR%\www\upload\all.tar.gz /S /Q >nul

:MAKE_TAR

ECHO Copying updates to the www_update directory....

REM M=archive attrib, S=subdirs, I=to directory, Y=overwrite
ECHO.
XCOPY * %CAESAR%\www_update /M /S /I /Y

IF NOT EXIST %CAESAR%\www_update MKDIR %CAESAR%\www_update

ECHO.
ECHO Creating %CAESAR%\www\upload\all.tar.gz...

cd %CAESAR%\www_update
ECHO.
tar cvfz ../www/upload/all.tar.gz --exclude=*.tag *

ECHO.
ECHO All done!

ECHO.
PAUSE
