		<table class="layout">
			<colgroup span="1" width="185"></colgroup>
			<colgroup span="1" width="8"></colgroup>
			<colgroup span="1"></colgroup>

			<tr>
				<td>
					<?php
						echo '<p><a href="' . $www_root . '"><img src="' . $www_root . 'resources/caesar_small.png" alt="CAESAR Logo" width="168" height="25"/></a></p>' . LF . LF;

						echo INDENT . '<p><small>Catalogue of Arcade Emulation Software - the Absolute Reference</small></p>' . LF . LF;

						if (isset($menu))
						{
							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>General</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . '">CAESAR Home</a></td></tr>' . LF;
							echo INDENT . '</table>' . LF . LF;
							echo INDENT . '<p></p>' . LF . LF;
						}

						if (isset($menu) && ($menu=="validate"))
						{
							echo INDENT . '<table class="menu">'. LF;
							echo INDENT . TAB . '<tr><th>Validate</th></tr>'. LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/validate.php?type=authors">Authors</a></td></tr>'. LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/validate.php?type=emus">Emus</a></td></tr>'. LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/validate.php?type=files">Files</a></td></tr>'. LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/validate.php?type=games">Games</a></td></tr>'. LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/validate.php?type=libs">Libs</a></td></tr>'. LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/validate.php?type=tools">Tools</a></td></tr>'. LF;
							echo INDENT . '</table>' . LF . LF;
							echo INDENT . '<p></p>' . LF;
						}

						else if (isset($menu) && ($menu=="games"))
						{
							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Names</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td>' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=a&amp;desc_match=before">0-9</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=a">A</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=b">B</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=c">C</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=d">D</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=e">E</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=f">F</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=g">G</a> |' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=h">H</a>' . LF;
							echo INDENT . TAB. '</td></tr>' . LF . LF;
							echo INDENT . TAB . '<tr class="even"><td>' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=i">I</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=j">J</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=k">K</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=l">L</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=m">M</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=n">N</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=o">O</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=p">P</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=q">Q</a>' . LF;
							echo INDENT . TAB. '</td></tr>' . LF . LF;
							echo INDENT . TAB . '<tr class="odd"><td>' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=r">R</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=s">S</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=t">T</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=u">U</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=v">V</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=w">W</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=x">X</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=y">Y</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?desc=z">Z</a>' . LF;
							echo INDENT . TAB. '</td></tr>' . LF . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF . LF;

							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Miscellaneous</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/game_search.php?nonmame=yes">Non-MAME Games</a></td></tr>' . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF . LF;

							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Years</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td>' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1970">1970</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1971">1971</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1972">1972</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1973">1973</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1974">1974</a>' . LF;
							echo INDENT . TAB. '</td></tr>' . LF . LF;
							echo INDENT . TAB . '<tr class="even"><td>' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1975">1975</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1976">1976</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1977">1977</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1978">1978</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1979">1979</a>' . LF;
							echo INDENT . TAB. '</td></tr>' . LF . LF;
							echo INDENT . TAB . '<tr class="odd"><td>' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1980">1980</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1981">1981</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1982">1982</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1983">1983</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1984">1984</a>' . LF;
							echo INDENT . TAB. '</td></tr>' . LF . LF;
							echo INDENT . TAB . '<tr class="even"><td>' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1985">1985</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1986">1986</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1987">1987</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1988">1988</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1989">1989</a>' . LF;
							echo INDENT . TAB. '</td></tr>' . LF . LF;
							echo INDENT . TAB . '<tr class="odd"><td>' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1990">1990</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1991">1991</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1992">1992</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1993">1993</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1994">1994</a>' . LF;
							echo INDENT . TAB. '</td></tr>' . LF . LF;
							echo INDENT . TAB . '<tr class="even"><td>' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1995">1995</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1996">1996</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1997">1997</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1998">1998</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=1999">1999</a>' . LF;
							echo INDENT . TAB. '</td></tr>' . LF . LF;
							echo INDENT . TAB . '<tr class="odd"><td>' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=2000">2000</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=2001">2001</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=2002">2002</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=2003">2003</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=2004">2004</a>' . LF;
							echo INDENT . TAB. '</td></tr>' . LF . LF;
							echo INDENT . TAB . '<tr class="even"><td>' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=2005">2005</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=2006">2006</a> | ' . LF;
							echo INDENT . TAB . TAB . '<a href="' . $www_root . 'php/game_search.php?year=????">????</a>' . LF;
							echo INDENT . TAB. '</td></tr>' . LF . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF . LF;

							// Select manfacturers
							
							$query = "SELECT manufacturer
								FROM manufacturer
								ORDER BY manufacturer";

							$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());
							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Manufacturers</th></tr>' .LF;

							$class = "odd";
							
							while ($row = mysql_fetch_assoc ($result))
							{
								echo INDENT . TAB . '<tr class="' . $class . '"><td>';
								echo '<a href="' . $www_root . 'php/game_search.php?manu=' . strtolower($row ['manufacturer']) . '&amp;manu_match=contains">' . $row ['manufacturer'];
								echo '</a></td></tr>' . LF;

								// Toggle even/odd

								$class = ($class == "even") ? "odd" : "even";
							}

							echo INDENT . '</table>' . LF . LF;

							mysql_free_result ($result);

							echo INDENT . '<p></p>' . LF;
						}

						else
						{
							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>General</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . '">Latest News</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'info/pastnews.php">Past News</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'info/about.php">About</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="http://forum.logiqx.com/">Forum</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'info/roms.php">ROM Tips</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'info/future.php">Future</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'info/faq.php">FAQ</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'info/links.php">Links</a></td></tr>' . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF . LF;

							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Search</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulator_search.php">Emulator Search</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/game_search.php">Game Search</a></td></tr>' . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF . LF;

							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Emus for DOS/Windows</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=single">Single Emus</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=multi">Multi Emus</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=sound">Sound Emus</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=commercial">Commercial Emus</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=fake">Fake Emus</a></td></tr>' . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF . LF;

							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Special Categories</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=recent">Recent Emus</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=recommended">Recommended</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=enhanced">Enhanced</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=screensavers">Screen Savers</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=nonmame">Non-MAME Games</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=oldnames">Old Names</a></td></tr>' . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF . LF;

							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Alternative Platforms</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=amiga">Amiga</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=arm">Arm / RISC OS</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=beos">BeOS</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=digita">Digita</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=linux">Linux</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=mac">Mac</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=os2">OS/2</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=palmos">Palm OS</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=psion">Psion</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=qnx">QNX</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=symbian">Symbian</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=wince">WinCE</a></td></tr>' . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF . LF;

							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Multi-Platform Emus</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=java">Java</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=shockwave">Shockwave Flash</a></td></tr>' . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF . LF;

							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Emulators on Consoles</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=gp32">GP32</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=xbox">Microsoft X-Box</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=psx">Sony Playstation</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=ps2">Sony Playstation 2</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=n64">Nintendo 64</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/emulators.php?id=saturn">Sega Saturn</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/emulators.php?id=dreamcast">Sega Dreamcast</a></td></tr>' . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF . LF;

							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Dev. Tools</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/tools.php?id=assemblers">Assemblers</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/tools.php?id=compilers">Compilers</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/tools.php?id=gfx_libs">Gfx Libraries</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/tools.php?id=snd_libs">Snd Libraries</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/tools.php?id=zip_libs">Zip Libraries</a></td></tr>' . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF . LF;

							echo INDENT . '<table class="menu">' . LF;
							echo INDENT . TAB . '<tr><th>Emulation Libs</th></tr>' . LF;
							echo INDENT . TAB . '<tr class="odd"><td><a href="' . $www_root . 'php/libraries.php?id=cpu">CPU Cores</a></td></tr>' . LF;
							echo INDENT . TAB . '<tr class="even"><td><a href="' . $www_root . 'php/libraries.php?id=snd">Snd Libraries</a></td></tr>' . LF;
							echo INDENT . '</table>' . LF . LF;

							echo INDENT . '<p></p>' . LF ;
						}

						echo INDENT . '<p>' . LF;

						if (!isset($non_xhtml_compliant))
						{
							echo INDENT . TAB . '<a href="http://validator.w3.org/check?uri=referer">';
							echo '<img src="' . $www_root . 'resources/valid-xhtml10.png" alt="Valid XHTML 1.0!" height="31" width="88"/>';
							echo '</a>' . LF;

							echo INDENT . TAB . '<a href="http://jigsaw.w3.org/css-validator/check/referer">';
							echo '<img src="' . $www_root . 'resources/valid-css.png" alt="Valid CSS!" height="31" width="88" />';
							echo '</a>' . LF;
						}

						echo INDENT . '</p>' . LF . LF;

						echo TAB . TAB . TAB . TAB . '</td>' . LF . LF;

						echo TAB . TAB . TAB . TAB . '<td></td>' . LF . LF;

						echo TAB . TAB . TAB . TAB . '<td>' . LF;

						echo INDENT . '<p><img src="' . $www_root . 'resources/caesar_big.png" alt="Large CAESAR Logo" width="495" height="104"/></p>' . LF;
					?>

