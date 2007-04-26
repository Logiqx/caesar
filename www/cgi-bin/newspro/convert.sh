sed 's/``x/|/g' newsdat.* | awk -F'|' '{print $6"|"$3"|"$5"|"$2"|||1||"}' | sed 's/,[0-9]*,//' >news.txt
