@ECHO OFF

REM --- Set the version number using the makefile

sed "s/^MAME_VER/SET &/" "%LOGIQX%/Dats/Recent/Multi/MAME/MAME.vers.mak"|grep "^SET " >"MAME.vers.bat"
CALL "MAME.vers.bat"
DEL "MAME.vers.bat"

REM --- Run MAMEDiff and MapTest

mamediff "multi/MAME_%MAME_VER_PREVIOUS%.dat" "multi/MAME_%MAME_VER_CURRENT%.dat"
mapfix -m -t

ECHO.
ECHO If you are happy with the fixes that will be applied, run 'mapfix -m'.
ECHO.
ECHO You can always edit mamediff.out and run 'mapfix -m -t' to tweak the behaviour.
ECHO.
ECHO Do NOT be tempted to edit the maps by hand. MapFix will remove your changes!
