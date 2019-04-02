<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../resources/include.php';

			// Display the page title

			echo '<title>CAESAR - FAQ</title>' . LF . LF;

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

		<h2>FAQ</h2>

		<p>Why doesn't every emulator have games listed?<br/>
		<i>Where there are several versions/ports of the same emulator,
		games are listed on the page for the main version. This is to
		keep the size of the index pages down (for your benefit).</i></p>

		<p>What's the difference between single and multi?<br/>
		<i>Single emus emulate a single game and possibly it's clones as
		well (clones as in MAME). Multi emus emulate two or more games
		that are not different versions of the same game.</i></p>

		<p>Where are the MAME emulator downloads?<br/>
		<i>There are so many different versions that I do not wish to provide them all online. It would
		use a lot of bandwidth and also create a lot more work for me!</i></p>

		<p>Where are the Neo-Geo CD Emulators?<br/>
		<i>Neo-Geo CD was a home system. This site is for machines in
		arcades.</i></p>

		<p>I've seen arcade perfect versions of Salamander (and other
		Konami games) on the Saturn. Why aren't they in CAESAR?<br/>
		<i>They have most likely taken the original source and ported it
		on the Saturn. It is not emulation.</i></p>

		<p>What's with the '.php' extension? I see it all over the
		place!<br/>
		<i>CAESAR uses the PHP scripting language to generate dynamic content.</i></p>

		<p>What are PNG images?<br/>
		<i>They are an alternative to GIFs and we're likely to see them
		start replacing GIFs over time.</i></p>

		<?php
			// Standard page footer (counter)

			include '../resources/bottom.php';
		?>
	</body>
</html>

