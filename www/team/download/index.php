<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../../resources/include.php';

			// Display the page title

			echo '<title>Logiqx - Team Downloads</title>' . LF . LF;

			// Include standard <head> metadata

			include '../../resources/head.php';
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the news)

			echo '<!-- Logiqx pages are basically a table with one row and three columns -->' . LF . LF;

			include '../../resources/top.php';
		?>

					<h1>ZIPs to extract into the 'CAESAR' area</h1>

					<h2>Mike's Backup (everything needed to build CAESAR)</h2>

					<table class="guide">
					    <tr>
						<th>File</th>
						<th>Size</th>
						<th>Description</th>
					    </tr>
					    <tr>
						<td><a href="bin.zip">bin.zip</a></td>
						<td>~0.5MB</td>
						<td>CAESAR executables, etc</td>
					    </tr>
					    <tr>
						<td><a href="data.zip">data.zip</a></td>
						<td>~6MB</td>
						<td>The data that is within CAESAR</td>
					    </tr>
					    <tr>
						<td><a href="dev.zip">dev.zip</a></td>
						<td>~1MB</td>
						<td>Source code for CAESAR executables, etc</td>
					    </tr>
					    <tr>
						<td><a href="www.zip">www.zip</a></td>
						<td>~1MB</td>
						<td>Web pages for caesar.logiqx.com</td>
					    </tr>
					</table>

		<?php
			// Standard page footer (counter)

			include '../../resources/bottom.php';
		?>
	</body>
</html>

