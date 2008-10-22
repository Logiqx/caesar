@echo off

mamediff -v nonmame.cps1.dat "E:\Logiqx\Dats\Recent\Systems\CPS-1\CPS-1 YYYYMMDD (Non-MAME).dat"
notepad mamediff.log

mamediff -v nonmame.cps2.dat "E:\Logiqx\Dats\Recent\Systems\CPS-2\CPS-2 YYYYMMDD (Non-MAME).dat"
notepad mamediff.log

REM mamediff -v nonmame.neo.2001+.dat "E:\Logiqx\Dats\Recent\Systems\Neo-Geo\Neo-Geo YYYYMMDD (2001+).dat"
REM notepad mamediff.log

mamediff -v nonmame.neo.misc.dat "E:\Logiqx\Dats\Recent\Systems\Neo-Geo\Neo-Geo YYYYMMDD (Misc).dat"
notepad mamediff.log

mamediff -v nonmame.neo.decrypted.dat "E:\Logiqx\Dats\Recent\Systems\Neo-Geo\Neo-Geo YYYYMMDD (Decrypted).dat"
notepad mamediff.log

rm -f mamediff.log mamediff.out
