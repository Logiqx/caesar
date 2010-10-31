import os

for fn in os.listdir('.'):
	if fn[:3] == 'arc' and fn.count('-20') == 1 and os.path.splitext(fn)[1] == '.txt':
		f = open(fn)
		tmp = open(os.path.join('tmp', fn), 'w')

		line = f.readline()

		while line:

			x = line.find('<a href', 0)

			while x >= 0:

				link = line[x : line.find('</a>', x) + 4]
				label = line[line.find('>', x) + 1 : line.find('</a>', x)]

				if link[:14] == '<a href="/html':
					print line
					line = line.replace(link, label)

					x = line.find('<a href', x)


				elif link[:38] == '<a href="http://caesar.logiqx.com/html':
					line = line.replace(link, label)

					x = line.find('<a href', x)

				elif link[:37] == '<a href="http://caesar.logiqx.com/php':
					line = line.replace(link, label)

					x = line.find('<a href', x)

				else:
					x = line.find('<a href', x + 1)

			tmp.write(line)
			line = f.readline()

		f.close()
		tmp.close()




