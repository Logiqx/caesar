@ECHO OFF

REM --- Standard file names

SET PC_TXT=_filelist_pc.txt
SET PC_TMP=_filelist_pc.tmp

REM --- Scan files

ECHO Scanning files...

filelist >%PC_TXT%
grep -v "./_filelist" %PC_TXT% >%PC_TMP%
sort %PC_TMP% >%PC_TXT%
rm -f %PC_TMP%

ECHO All done!

ECHO.
PAUSE
