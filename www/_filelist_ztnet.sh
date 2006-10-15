# --- Standard file names

ZTNET_TXT=_filelist_ztnet.txt
ZTNET_TMP=_filelist_ztnet.tmp

# --- Scan files

echo "Scanning files..."

filelist >$ZTNET_TXT
grep -v "./_filelist" $ZTNET_TXT >$ZTNET_TMP
sort $ZTNET_TMP >$ZTNET_TXT
rm -f $ZTNET_TMP

echo "All done!"
