#!/usr/bin/env python

import os, stat, platform

def read_filelist(node, altNode):
	'''read_filelist(node, altNode)

	Read a filelist into a dictionary object'''

	dict = {}

	fn = '_filelist_' + node + '.txt'
	altFn = '_filelist_' + altNode + '.txt'

	f = open(fn, "r")
	st = f.readline()
	while (st):
		# Strip whitespace from the end of the line and ensure that seperator is used
		parts = st.rstrip().replace('/', os.sep).replace('\\', os.sep).split('\t')

		# Ignore the file if it is for the other alternative node
		if parts[1] != altFn:
			dict[os.path.join(parts[0], parts[1])] = parts[2]

		# Read the next line
		st = f.readline()
	f.close()

	return dict


# Generate the filelist
cmd = '_filelist.py'
print 'Running %s...' % cmd
os.system(cmd)
print

# Determine the filenames
laptopNode = 'inspiron'
serverNode = platform.node().lower().split('.')[0]

# Load the filelists into memory
laptopFiles = read_filelist(laptopNode, serverNode)
serverFiles = read_filelist(serverNode, laptopNode)

# Initialise reports
incorrectFiles = []
missingFiles = []
unneededFiles = []

# Check that all laptop files are present on the server
laptopKeys = laptopFiles.keys()
laptopKeys.sort()
for file in laptopKeys:
	if serverFiles.has_key(file):
		if serverFiles[file] != laptopFiles[file]:
			print "Wrong size: %s (%s bytes)" % (file, serverFiles[file])
			incorrectFiles.append(file)
	else:
		print "Missing: %s (%s bytes)" % (file, laptopFiles[file])
		missingFiles.append(file)

if incorrectFiles or missingFiles:
	print

# Check that all server files are present on the laptop
serverKeys = serverFiles.keys()
serverKeys.sort()
for file in serverKeys:
	if not laptopFiles.has_key(file):
		print "Unneeded: %s (%s bytes)" % (file, serverFiles[file])
		unneededFiles.append(file)

# If there are any unneeded files then build a shell script to remove them
if unneededFiles:
	fn = '_filelist_tidy.sh'
	f = open(fn, 'w')
	for file in unneededFiles:
		f.write('rm "%s"' % file + os.linesep)
	f.write('rm -f "%s"' % fn + os.linesep)
	f.write('_filelist_compare.py' + os.linesep)
	f.close()
	os.chmod(fn, os.stat(fn)[0] | stat.S_IXUSR | stat.S_IXGRP | stat.S_IXOTH)
	print
	print 'Run %s to remove all unneeded files.' % fn
	print

# Report the totals
print "Totals: incorrect = %d, missing = %d, unneeded = %d" % (len(incorrectFiles), len(missingFiles), len(unneededFiles))

