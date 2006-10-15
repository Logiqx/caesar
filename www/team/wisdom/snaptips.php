<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../../resources/include.php');

			// Display the page title

			echo '<title>Snapshot Notes</title>' . LF . LF;

			// Include standard <head> metadata

			include('../../resources/head.php');
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the news)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			include('../../resources/top.php');
		?>

					<h1>Snapshot Notes</h1>

					<p>
					As several of us will be doing snaps for CAESAR I thought I'd draw up a
					few simple guidelines. This is because I have done some snapping myself and
					I thought it would be a good idea to write some things down that I
					encountered or occurred to me whilst doing them.
					</p>

					<p>
					Please try to read through these points. Most of them seem obvious but they
					should help CAESAR consistent throughout.
					</p>

					<h2>Useful Tools - http://www.logiqx.com/caesar/team</h2>

					<p>
					mamenew.zip - MAMEDiff logs detailing games that will need snapping<br />
					chksnaps.zip - My tool for checking snaps you make<br />
					snaplist.zip - Data file for chksnaps.exe<br />
					targz.zip - Tar and GNU ZIP (used to compress the snaps into a single tar.gz prior to uploading)<br />
					VThief.zip - A snapshot tool for DOS emus that don't have a snapshot facility<br />
					http://caesar.logiqx.com/team/ - Useful team information<br />
					</p>

					<h2>File Format - checked by chksnaps.exe</h2>

					<p>
					PNG, Non-interlaced and no transparency.
					JPEG was used for EmuDX but I'd prefer real arcade graphics to be untouched
					by lossy compression techniques.
					</p>

					<h2>Size - NOT checked by chksnaps.exe, must be done visually by humans</h2>

					<p>
					Original arcade resolution. Sometimes an emu will use PC modes (like
					640x480) so you may have to resize the image (e.g. half size if it was pixel
					doubled by the emu) and remove black borders at top/bottom/sides. Switch scanlines
					off when taking snapshots as you could have problems resizing the image afterwards.
					These points are probably the most important for good looking web pages!
					</p>

					<p>
					Paint Shop Pro 7 has a 'Change Canvas Size' feature wich is very useful for removing
					black borders.
					</p>

					<h2>Orientation</h2>

					<p>
					If the emulator supports rotation of vertical games then try to check that
					the snaps are not on their side. If the emu's snap feature saves images on
					their side then they can be rotated in PSP or similar.
					</p>

					<h2>Colours - checked by chksnaps.exe</h2>

					<p>
					If the image uses &lt;=256 colours then save as a 256 colour image, otherwise
					16.7M. 256 colour PNG files are half the size of 16M colour ones.
					</p>

					<h2>Windows Emus</h2>

					<p>
					Beware of bilinear filtering by some Windows emus (e.g. Final Burn with my GeForce 2
					card). In Final Burn it's a matter of me resizing the window so graphics use 1x1
					pixels. Bilinear filtering blurs the image, increases the number of colours and
					makes it impossible to resize the image as desired in any paint program. My next
					option would be to to use my old PC with a less exotic graphics card!
					</p>

					<h2>Filenames/Directories - checked by chksnaps.exe</h2>

					<p>
					Game snaps: snaps/emus/&lt;type&gt;/&lt;emu&gt;/&lt;game&gt;_&lt;x&gt;.png<br />
					GUI snaps: snaps/emus/&lt;type&gt;/&lt;emu&gt;_&lt;x&gt;.png
					</p>

					<h2>Game snaps</h2>

					<p>
					Most games will require two snaps, some will only require one, some could
					require lots (e.g 3 Wonders which is basically 3 different games). Typically:
					</p>

					<ol>
					<li>Title Screen showing 'Insert Coin'</li>
					<li>Character select (fighter games), car/circuit select (car games)</li>
					<li>In game snap showing some typical action. This is not as easy as expected
					as snapshots can catch peculiar frames sometimes!</li>
					</ol>

					<p>
					I leave it to your own judgement as to whether a game should vary from the
					normal two snaps. Fighters where there is a good character selection should
					ideally have three snaps (as described above).
					</p>

					<h2>GUI snaps</h2>

					<p>
					Try to make it as interesting as possible. Have a game running, select an
					interesting menu option etc (see Callus as an example).
					</p>

					<h2>Uploading - use batch script in targz.zip</h2>

					<p>
					Upload as a .tar.gz that contains the exact directory structure for caesar
					(snaps/emus/.......) so it can be uncompressed on the server without the
					need for re-uploading.  The files go in your own upload directory (I will
					inform you each of your logins individually).
					</p>

					<h2>Trial</h2>

					<p>
					It is worth doing a couple of practice snaps in a new emu before going
					through all the games. After making a couple of snaps you can load up PSP
					and work out what needs doing in terms of number of colours, resizing,
					rotating etc.
					</p>

		<?php
			// Standard page footer (counter)

			include('../../resources/bottom.php');
		?>
	</body>
</html>

