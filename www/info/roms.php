<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../resources/include.php';

			// Display the page title

			echo '<title>CAESAR - ROM Tips</title>' . LF . LF;

			// Include standard <head> metadata

			include '../resources/head.php';
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the news)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			include '../resources/top.php';
		?>

		<h2>ROM Tips</h2>

		<p>When trying out emulators other than MAME you will often find
		that MAME ROM sets are not recognised. The reason for this can be
		as simple as different filenames or something like the ROMs being
		split in two etc. To build working ROM sets for emulators other
		than MAME, try out the ROM managers <a href=
		"http://www.mameworld.net/clrmame/">ClrMAMEPro</a> and <a href=
		"http://www.romcenter.com">ROMCenter</a>. Both require 'dats' to
		define what ROMs are needed by the emulator and I supply these at
		my <a href="http://www.logiqx.com">home page</a>.</p>

		<p>Occasionally the ROM manager and dat still isn't capable of
		building the ROMs that you require. If this is the case you will
		need to use <a href="http://www.logiqx.com">ROMBuild</a> (written
		by myself) and feed the output of that into your ROM manager.</p>

		<p>You should also be familiar with the legality of arcade ROMs.
		In short, if you don't own the original arcade board then you
		aren't entitled to use the ROMs in an emulator.</p>

		<?php
			// Standard page footer (counter)

			include '../resources/bottom.php';
		?>
	</body>
</html>

