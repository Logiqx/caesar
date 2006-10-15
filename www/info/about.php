<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Display the page title

			echo '<title>CAESAR - About</title>' . LF . LF;

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

		<h2>About CAESAR</h2>

		<p>The aim of CAESAR is to be the definitive reference for all
		arcade emulators and for the games that they support. It includes
		cross references for all games, allowing you to see which
		emulators support a particular game and it also knows all of the
		games not in MAME but supported by other emus. CAESAR contains a
		large amount of information about the emulators themselves and
		has the vast majority of emulators available to download.</p>

		<p>Do not mistake CAESAR for being thousands of manually typed
		HTML pages. If CAESAR were like that it would be impossible to
		maintain! CAESAR is structured data on my PC that gets loaded into a MySQL
		database and ends up being rendered as XHTML pages using PHP.</p>

		<h2>Contacting Us</h2>

		<p>If you are new to emulation and have general questions about
		it then take a trip to <a href=
		"http://www.mameworld.net/easyemu">EasyEmu</a>.</p>

		<p>For CAESAR related issues and to inform us about news stories
		visit the <a href=
		"http://www.logiqx.com/forum/viewforum.php?f=15">forum</a>.</p>

		<p>Please do not ask us where you can find the ROMs!</p>

		<h2>The Team</h2>

		<table class="links">
			<colgroup></colgroup>

			<tr>
				<th>Current Team Members</th>
			</tr>

			<tr class="odd">
				<td><a href="http://www.logiqx.com/">Logiqx</a> - Conception,
				research, design, development, implementation and maintenance
				(read <a href="interview.php">interview</a>)</td>
			</tr>

			<tr class="even">
				<td><a href="http://caesar.logiqx.com/">Pi</a> - Additional
				research, testing, news posting and over 5000 snapshots
				(prior to MAME v0.37 b11)</td>
			</tr>
		</table><br/>

		<table class="links">
			<colgroup></colgroup>

			<tr>
				<th>Previous Team Members</th>
			</tr>

			<tr class="odd">
				<td>Rob - News posts around July 2001</td>
			</tr>

			<tr class="even">
				<td>GordonJ - News posts around October 2001</td>
			</tr>

			<tr class="odd">
				<td>Jokie - Snapshots for MAME v0.37 beta 11 to MAME v0.37
				beta 13</td>
			</tr>
		</table><br/>

		<table class="links">
			<colgroup></colgroup>

			<tr>
				<th>Thanks</th>
			</tr>

			<tr class="odd">
				<td><a href="http://www.arcade-history.com/">The Arcade History Database</a>
				for History.dat</td>
			</tr>

			<tr class="even">
				<td><a href="http://www.mameworld.net/mameinfo/">MASH</a>
				for MAMEInfo.dat</td>
			</tr>

			<tr class="odd">
				<td><a href="http://crashtest.retrogames.com/">CrashTest</a>
				for his <a href="../php/emulator.php?id=mame">MAME</a>,
				<a href="../php/emulator.php?id=modeler">Modeler</a>,
				<a href="../php/emulator.php?id=s11emu">S11Emu</a> and
				<a href="../php/emulator.php?id=nebulam2">Nebula Model 2</a>
				snapshots</td>
			</tr>

			<tr class="even">
				<td><a href="http://unemulated.emuunlim.com/">The Guru</a>
				and <a href=
				"http://www.classicgaming.com/mame32qa/">JohnIV</a> for all
				of the cabinet images</td>
			</tr>

			<tr class="odd">
				<td><a href="http://www.arcadeflyers.com/">The Arcade Flyer
				Archive</a> for their flyer images</td>
			</tr>

			<tr class="even">
				<td><a href="http://www.eldio.co.uk/">Eldio</a> for all of his
				marquee images</td>
			</tr>

			<tr class="odd">
				<td>C0llector - Snapshots for <a href=
				"../php/emulator.php?id=impact">Impact</a>, <a href=
				"../php/emulator.php?id=rage">RAGE</a> and <a href=
				"../php/emulator.php?id=m72">M72 Emulator</a></td>
			</tr>

			<tr class="even">
				<td>Leslaw - Snapshots for <a href=
				"../php/emulator.php?id=hive">HiVE</a>, <a href=
				"../php/emulator.php?id=asteroids">Asteroids Emulator</a>,
				<a href="../php/emulator.php?id=astdx">AstDX</a> and
				<a href="../php/emulator.php?id=bombjack_pc">Bombjack
				PC</a></td>
			</tr>
		</table><br/>

		<h2>Technical Information</h2>

		<table class="links">
			<colgroup></colgroup>

			<tr>
				<th>Web Technologies</th>
			</tr>

			<tr class="odd">
				<td><a href="http://www.apache.org/">Apache</a> v1.3.33 (v2.0.53 during development)</td>
			</tr>

			<tr class="even">
				<td><a href="http://www.php.net/">PHP</a> v4.3.11 (v4.3.10 during development)</td>
			</tr>

			<tr class="odd">
				<td><a href="http://www.mysql.com/">MySQL</a> v4.1.13 (v4.1.17 during development)</td>
			</tr>

			<tr class="even">
				<td><a href="http://www.w3.org/MarkUp/">XHTML</a> 1.0 and the <a href="http://validator.w3.org/">validation</a> service</td>
			</tr>

			<tr class="odd">
				<td><a href="http://www.w3.org/Style/CSS/">CSS</a> 2.0 and the <a href="http://jigsaw.w3.org/css-validator/">validation</a> service</td>
			</tr>

			<tr class="even">
				<td><a href="http://www.w3.org/Graphics/PNG/">PNG</a> and <a href="http://www.jpeg.org/">JPEG</a></td>
			</tr>
		</table><br/>

		<table class="links">
			<colgroup></colgroup>

			<tr>
				<th>Development Technologies and Tools</th>
			</tr>

			<tr class="odd">
				<td><a href="http://www.w3.org/XML/">XML</a> and <a href="http://www.w3.org/Style/XSL/">XSL</a></td>
			</tr>

			<tr class="even">
				<td><a href="http://www.gingerall.com/charlie/ga/xml/p_sab.xml">Sablotron</a> (sabcmd 0.96 which is an <a href="http://www.w3.org/Style/XSL/">XSLT</a> engine) by Ginger Alliance Ltd</td>
			</tr>

			<tr class="odd">
				<td><a href="http://www.vim.org/">GVIM</a> (Graphical Vi IMproved). The greatest text editor
				ever but not for the faint hearted!</td>
			</tr>

			<tr class="even">
				<td><a href="http://mingw.sourceforge.net/">MinGW + MSYS</a></td>
			</tr>
		</table><br/>

		<?php
			// Standard page footer (counter)

			include('../resources/bottom.php');
		?>
	</body>
</html>

