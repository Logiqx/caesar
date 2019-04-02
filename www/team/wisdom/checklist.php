<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../../resources/include.php';

			// Display the page title

			echo '<title>Mike\'s checklist for updating mappings (after a MAME release)</title>' . LF . LF;

			// Include standard <head> metadata

			include '../../resources/head.php';
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the news)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			include '../../resources/top.php';
		?>

					<h1>Mike's checklist for updating mappings<br />(after a MAME release)</h1>

					<p>Synchronise 'nonmame' data files with the latest logiqx.com data files.</p>

					<p>1) Generate a new MAME listinfo file</p>

<pre>
cd \caesar\data\games
mamepp -listxml &gt;"multi\MAME_v0.xx.dat"
</pre>

					<p>2) Check for non-MAME name conflicts (against the new MAME)</p>

<pre>
_nonmame_to_mame.bat
</pre>

					<p>3) Check for MAME map changes (i.e. MAME renames)</p>

<pre>
_mame_map_test.bat
</pre>

					<p>4) Check for Non-MAME map changes (i.e. Non-MAME to MAME)</p>

<pre>
_nonmame_map_test.bat
</pre>

					<p>5) Move the old MAME data file out of the way</p>

<pre>
mv "multi/MAME_v0.zz.dat" .
</pre>

					<p>6) Check that map based logs have not changed</p>

<pre>
notin multi/MAME*dat nonmame.dat
diff -r logs.map logs
</pre>

					<p>7) Check that dat based logs have not changed</p>

<pre>
notin -d multi/MAME*dat nonmame.dat
diff -r logs.dat logs
</pre>

					<p>8) Clean up</p>

<pre>
rm mame* MAME*
</pre>
		<?php
			// Standard page footer (counter)

			include '../../resources/bottom.php';
		?>
	</body>
</html>

