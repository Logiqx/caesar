<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Display the page title

			echo '<title>CAESAR - Future</title>' . LF . LF;

			// Include standard <head> metadata

			include('../resources/head.php');
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the news)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			include('../resources/top.php');
		?>

		<h2>Future</h2>

		<p>My aim is to get all of the missing emulators and if possible, snapshots into CAESAR.</p>
		
		<p>If you can help me find the following emulators I would be grateful:</p>

		<table class="links">
			<colgroup></colgroup>

			<tr>
				<th>Missing In Action!</th>
			</tr>

			<tr class="odd">
				<td>Stargate+Defender for the BeBox by Joe Britt (never
				released?)</td>
			</tr>
		</table>

		<table class="links">
			<colgroup></colgroup>

			<tr>
				<th>Got on my PC - I will process them when I get some
				time!</th>
			</tr>

			<tr class="odd">
				<td>Tecmo Arcade for the X-Box</td>
			</tr>

			<tr class="even">
				<td>A variety of emulators for the Dreamcast from
				Reaper2K2</td>
			</tr>

			<tr class="odd">
				<td>PacPackDC for the Dreamcast</td>
			</tr>
		</table>

		<?php
			// Standard page footer (counter)

			include('../resources/bottom.php');
		?>
	</body>
</html>

