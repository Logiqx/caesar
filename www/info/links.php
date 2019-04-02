<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../resources/include.php';

			// Display the page title

			echo '<title>CAESAR - Links</title>' . LF . LF;

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

			<h2>Recommended Links</h2>

		<table class="links">
			<colgroup></colgroup>

			<tr>
				<th>Arcade Game Information</th>
			</tr>

			<tr class="odd">
				<td><a href="http://www.system16.com/">System 16 - The Arcade Museum</a><br/>
				Sixtoe's excellent site provides information about arcade machines produced by
				Sega, Atari, Capcom, Irem, Konami, Midway, Namco, Taito and a few other manufacturers.</td>
			</tr>

			<tr class="even">
				<td><a href="http://www.klov.com/">KLOV.com</a><br/>
				The home of The Killer List of Videogames! The information on
				the site has been gathered from countless collectors and is
				always being updated with new titles</td>
			</tr>

			<tr class="odd">
				<td><a href=
				"http://www.gamefaqs.com/coinop/arcade/index.html">GameFAQs</a><br/>

				This site contains loads of information of arcade games</td>
			</tr>

			<tr class="even">
				<td><a href="http://uvl.arteh.com">Universal Videogame
				List</a><br/>
				This site contains information on many platforms but of
				particular interest is the arcade section.</td>
			</tr>

			<tr class="odd">
				<td><a href="http://www.arcadeflyers.com/">The Arcade Flyer
				Archive</a><br/>
				An enormous collection of high quality arcade flyer
				images</td>
			</tr>
		</table>

		<table class="links">
			<colgroup></colgroup>

			<tr>
				<th>Emulated Arcade Games</th>
			</tr>

			<tr class="odd">
				<td><a href="http://www.mameworld.net/maws/">MAWS</a><br/>
				Cutebutwrong's one-stop-shop for anything that you want to know about the games in MAME.</td>
			</tr>

			<tr class="even">
				<td><a href="http://emustatus.rainemu.com/">Emulation
				Status</a><br/>
				Warlock has created a site that contains information on his
				favourite arcade games. It includes screenshots, tech info,
				emulation status and also monitors new developments.</td>
			</tr>

			<tr class="odd">
				<td><a href="http://gamebase.retrogames.com/">Theo's Page of
				Emulated Games</a><br/>
				Theo has dedicated this site to classic video games. He is
				trying to include all games from the past which are either
				emulated or for which he has the manufacturer and release
				year.</td>
			</tr>

			<tr class="even">
				<td><a href=
				"http://nonmame.retrogames.com/">NonMAME!</a><br/>
				Shoegazer's site is a list of arcade emulators that support games
				other than the ones already in MAME/MAME32.</td>
			</tr>

			<tr class="odd">
				<td><a href="http://www.mameworld.net/mameperf/">ArchieMan's
				MAME Performance Guide</a><br/>
				This site is intended to give MAME users an idea of what to
				expect from their systems when running games in MAME.</td>
			</tr>
		</table>

		<table class="links">
			<colgroup></colgroup>

			<tr>
				<th>Unemulated Arcade Games</th>
			</tr>

			<tr class="odd">
				<td><a href="http://www.mameworld.net/gurudumps/">The Guru's
				ROM Dumping News</a><br/>
				Home of the New Dumping Project...
				they aim to buy and dump everything that is not currently dumped.</td>
			</tr>

			<tr class="even">
				<td><a href="http://unmamed.mame.net/">UnMAMEd Arcade
				Games</a><br/>
				Bobby Tribble's page is for keeping track of which arcade games are
				currently unemulated... and for the technical reasons why
				not! Also has links to pretty much all of the arcade
				emulation WIP pages. Visit it now!</td>
			</tr>
		</table>

		<?php
			// Standard page footer (counter)

			include '../resources/bottom.php';
		?>
	</body>
</html>

