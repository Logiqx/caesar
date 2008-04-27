#!/usr/bin/env python

import os, stat, platform

def read_filelist(node, altNode):
	dict = {}
	fn = '_filelist_' + node + '.txt'
	altFn = '_filelist_' + altNode + '.txt'
	f = open(fn, "r")
	st = f.readline()
	while (st):
		parts = st.rstrip().split('\t')
		if parts[1] != fn and parts[1] != altFn:
			dict[os.path.join(parts[0], parts[1])] = parts[2]
		st = f.readline()
	f.close()
	return dict

cmd = '_filelist.py'
print 'Running %s...' % cmd
os.system(cmd)
print

laptopNode = 'inspiron'
serverNode = platform.node().lower().split('.')[0]

laptopFiles = read_filelist(laptopNode, serverNode)
serverFiles = read_filelist(serverNode, laptopNode)

incorrectFiles = []
missingFiles = []
unneededFiles = []

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

serverKeys = serverFiles.keys()
serverKeys.sort()
for file in serverKeys:
	if not laptopFiles.has_key(file):
		print "Unneeded: %s (%s bytes)" % (file, serverFiles[file])
		unneededFiles.append(file)

if unneededFiles:
	fn = '_filelist_tidy.sh'
	f = open(fn, 'w')
	for file in unneededFiles:
		f.write('rm "%s"%s' % (file, os.linesep))
	f.write('rm "%s"%s' % (fn, os.linesep))
	f.close()
	os.chmod(fn, os.stat(fn)[0] | stat.S_IXUSR | stat.S_IXGRP | stat.S_IXOTH)
	print
	print 'Run %s to remove all unneeded files.' % fn
	print

print "Totals: incorrect = %d, missing = %d, unneeded = %d" % (len(incorrectFiles), len(missingFiles), len(unneededFiles))

