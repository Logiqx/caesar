@ECHO OFF

REM --- Set the version number using the makefile

sed "s/^MAME_VER/SET &/" "%LOGIQX%/Dats/Recent/Multi/MAME/MAME.vers.mak"|grep "^SET " >"MAME.vers.bat"
CALL "MAME.vers.bat"
DEL "MAME.vers.bat"

REM --- Run MAMEDiff and MapTest

mamediff nonmame.dat "multi/MAME_%MAME_VER_CURRENT%.dat"
mapfix -n -t

ECHO.
ECHO If you are happy with the fixes that will be applied, run 'mapfix -n'.
ECHO.
ECHO You can edit nonmame.dat and the maps if you wish, then run this script again.
