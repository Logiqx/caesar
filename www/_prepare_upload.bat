@ECHO OFF

CALL _filelist.py

IF NOT EXIST %CAESAR%\www\upload MKDIR %CAESAR%\www\upload
IF NOT EXIST %CAESAR%\www\upload\all.zip GOTO MAKE_ZIP

DEL %CAESAR%\www\upload\all.zip /S /Q >nul

:MAKE_ZIP

ECHO Copying updates to the www_update directory....

REM M=archive attrib, S=subdirs, I=to directory, Y=overwrite
ECHO.
XCOPY * %CAESAR%\www_update /M /S /I /Y

IF NOT EXIST %CAESAR%\www_update MKDIR %CAESAR%\www_update

ECHO.
ECHO Creating %CAESAR%\www\upload\all.zip...

cd %CAESAR%\www_update
ECHO.
zip -r -9 ../www/upload/all.zip *

ECHO.
ECHO All done!

ECHO.
PAUSE
