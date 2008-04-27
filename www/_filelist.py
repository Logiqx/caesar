#!/usr/bin/env python

import os, platform

ignoreDirs = \
[
	'./cache',
	'./news',
	'./cgi-bin/newspro',
	'./cutenews',
	'./team/download',
	'./team/pi'
]

node = platform.node().lower().split('.')[0]
f = open('_filelist_' + node + '.txt', "w")

for root, dirs, files in os.walk('.', topdown = True):

	for file in files:
		size = str(os.stat(os.path.join(root, file)).st_size)
		f.write(root.replace(os.sep, '/') + '\t' + file + '\t' + size + '\n')

	for ignoreDir in ignoreDirs:
		ignoreDir = ignoreDir.replace('/', os.sep)
		if os.path.dirname(ignoreDir) == root:
			if dirs.count(os.path.basename(ignoreDir)) > 0:
				dirs.remove(os.path.basename(ignoreDir))

f.close()
