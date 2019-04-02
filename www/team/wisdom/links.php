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

					<h1>Linking example<br />(how emulators are related)</h1>

					<img src="links.png" width="484" height="488" alt="Links" />

		<?php
			// Standard page footer (counter)

			include '../../resources/bottom.php';
		?>
	</body>
</html>

