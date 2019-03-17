notin -d multi/MAME*dat nonmame.dat

diff -r logs.dat logs | grep -v "ng-sfix.rom" | grep -v "ng-sm1.rom" | grep -v sm1.sm1 | grep -v sfix.sfx | grep -v 000-lo.lo | grep -v m1_decrypted | grep -v m1\. | grep -v m1d\. | grep -v 6d0a728e | grep -v 2e5767a4 >0

gvim 0
