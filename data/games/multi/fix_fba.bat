@ECHO OFF

SET FBA_VER=v0.2.95.23

COPY "FBA %FBA_VER%.dat" 0

grep -v "d27a71f1" 0 >1
grep -v "698ebb7d" 1 >0
grep -v "4fa698e9" 0 >1
grep -v "16d0c132" 1 >0
grep -v "0c12c2ad" 0 >1

mv 1 "FBA %FBA_VER%.dat"

rm 0
