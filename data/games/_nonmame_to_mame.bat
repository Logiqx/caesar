@ECHO OFF

REM --- Set the version number using the makefile

sed "s/^MAME_VER/SET &/" "%LOGIQX%/Dats/Recent/Multi/MAME/MAME.vers.mak"|grep "^SET " >"MAME.vers.bat"
CALL "MAME.vers.bat"
DEL "MAME.vers.bat"

REM --- Run MAMEDiff

mamediff -= -v nonmame.dat "multi/MAME_%MAME_VER_CURRENT%.dat"
notepad mamediff.log
DEL mamediff.log

ECHO.
ECHO Look at games with ROM additions. If they are not the same game, rename them!
ECHO.
ECHO You should rename such games to avoid errors when the map conversions are done.
