#!/usr/bin/env python

import os, platform

# List of directories to ignore

ignoreDirs = \
[
	'./cache',
	'./cutenews',
	'./team/download',
]

# Use the machine name (node) as part of the filename
node = platform.node().lower().split('.')[0]
fn = '_filelist_' + node + '.txt'
f = open(fn, "wb")

# The os.walk() function makes this a very simple activity!
for root, dirs, files in os.walk('.', topdown = True):

	# List all of the files in the current direcory
	for file in files:
		# Do not list this file though
		if file != fn:
			# Calculate the filesize and write the information to the filelist
			size = str(os.stat(os.path.join(root, file)).st_size)
			f.write(root + '\t' + file + '\t' + size + os.linesep)

	# Ensure that the specified directories are ignored
	for ignoreDir in ignoreDirs:
		ignoreDir = ignoreDir.replace('/', os.sep).replace('\\', os.sep)
		if os.path.dirname(ignoreDir) == root:
			if dirs.count(os.path.basename(ignoreDir)) > 0:
				dirs.remove(os.path.basename(ignoreDir))

# Close the output file
f.close()

