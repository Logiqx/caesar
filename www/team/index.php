<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../resources/include.php';

			// Display the page title

			echo '<title>The Remains of Team CAESAR!</title>' . LF . LF;

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

					<h1>The Remains of Team CAESAR!</h1>

					<h2>CGI scripts:</h2>

					<p><a href="../cgi-bin/untar_all.cgi">untar_all.cgi</a> (Extract upload.tar.gz)</p>

					<h2>Stuff to use:</h2>

					<p><a href="download/">Things to download</a> (backups and tools...)</p>

					<h2>Lessons and other pearls of wisdom:</h2>

					<p><a href="wisdom/CAESAR.doc">CAESAR.doc</a> - The main documentation (Word format)</p>
					<p><a href="wisdom/checklist.php">Checklist</a> for mapping updates after a new MAME release</p>
					<p><a href="wisdom/links.php">Linking example</a> (how emulators are related)</p>
					<p><a href="wisdom/snaptips.php">Snapshot tips</a> (for anyone creating snapshots)</p>
		<?php
			// Standard page footer (counter)

			include '../resources/bottom.php';
		?>
	</body>
</html>

