<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Display the page title

			$query = 'SELECT name
				FROM author
				WHERE author_id=' . "'" . $_GET ['id'] . "'";

			$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

			if (mysql_num_rows ($result) != 0)
			{
				$row = mysql_fetch_assoc ($result);

				echo '<title>CAESAR - ' . $row ['name'] . '</title>' . LF . LF;
			}
			else
			{
				echo '<title>CAESAR</title>' . LF . LF;
			}

			mysql_free_result ($result);

			// Include standard <head> metadata

			include ('../resources/head.php');
		?>

		<script type="text/javascript">
			<!--
				ENC_MIN = 0x20;
				ENC_MAX = 0x7a;
				ENC_MOD = (ENC_MAX - ENC_MIN + 1);
				
    				function decrypt(inSt, key)
    				{
   					shift = 0;
					for (i = 0; i < key.length; i++)
					{
						shift = shift + key.charCodeAt(i);
					}

    					outSt = '';
    					for (i = 0; i < inSt.length; i++)
					{
        					thisChar = inSt.charCodeAt(i);
						if (thisChar >= ENC_MIN && thisChar <= ENC_MAX)
						{
							thisChar = (thisChar - ENC_MIN + shift) % ENC_MOD + ENC_MIN;
						}
        					outSt += String.fromCharCode(thisChar);
        					shift = shift + thisChar;
					}

					return outSt;
				}

				function display_link(p1, p2, p3, p4)
				{
					p2 = decrypt(p2, p1);
					p3 = decrypt(p3, p2);
					p4 = decrypt(p4, p3);
					document.write('<a href=\"' + p2 + p3 + '@' + p4 + '\">');
					document.write(p3 + '@' + p4 + '</a>'); 
				}
			//-->
		</script>
	</head>
	<body>
		<?php
			// Encryption function for e-mail addresses

			function encrypt($inSt, $key)
			{
				$ENC_MIN = 0x20;
				$ENC_MAX = 0x7a;
				$ENC_MOD = ($ENC_MAX - $ENC_MIN + 1);

    				$shift = 0;
				for ($i = 0; $i < strlen($key); $i++)
				{
        				$shift = $shift + ord($key[$i]);
				}

    				$outSt = '';
				for ($i = 0; $i < strlen($inSt); $i++)
				{
					$thisChar = ord($inSt[$i]);

					if ($thisChar >= $ENC_MIN and $thisChar <= $ENC_MAX)
					{
						// Encode the character
						$tmp = ($thisChar - $ENC_MIN - $shift) % $ENC_MOD;

						// Cope with negative modulus (bug in PHP)
						while ($tmp < 0)
						{
							$tmp += $ENC_MOD;
						}

						// Cope with characters that need an extra backslash
						$tmp = chr($tmp + $ENC_MIN);

						if ($tmp == '\\' or $tmp == '"')
						{
							$tmp = '\\' . $tmp;
						}

						// Add the encoded character to the string
            					$outSt = $outSt . $tmp;
					}
					else
					{
						$outSt += $thisChar;
					}

					$shift = $shift + $thisChar;
				}

				return $outSt;
			}

			// The main page content is a 3 column table (left column is the menu, right one is the information)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			include ('../resources/top.php');

			// Select the page title and comment

			$query = 'SELECT *
				FROM author
				WHERE author_id=' . "'" . $_GET ['id'] . "'";

			$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

			// If no rows were found, the id was invalid (or unspecified)

			if (mysql_num_rows ($result) != 0)
			{
				// Title and comment

				$row = mysql_fetch_assoc ($result);

				echo INDENT . '<h2>' . $row ['name'] . '</h2>' . LF . LF;

				// Create table for the links and define the column groups

				echo INDENT . '<table class="details">' . LF;

				echo INDENT . TAB . '<colgroup class="heading"/>' . LF;
				echo INDENT . TAB . '<colgroup class="details"/>' . LF;

				$class = 'odd';

				// E-Mail addresses

				$query = "SELECT *
					FROM	author_email
					WHERE	author_id='". $_GET ['id'] . "'";

				$emails = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
				echo INDENT . TAB . TAB . '<th>E-mail</th>' . LF;

				echo INDENT . TAB . TAB . '<td>' . LF;

				if (mysql_num_rows ($emails) != 0)
				{
					while ($email = mysql_fetch_assoc ($emails))
					{
						$id = $_GET ['id'];
						$mailto = 'mailto:';
						$username = substr($email ['email'], 0, strpos($email ['email'], '@'));
						$hostname = substr($email ['email'], strpos($email ['email'], '@')+1);

						$hostname = encrypt($hostname, $username);
						$username = encrypt($username, $mailto);
						$mailto = encrypt($mailto, $id);

						echo INDENT . TAB . TAB . TAB . '<script type="text/javascript">' . LF;
						echo INDENT . TAB . TAB . TAB . TAB . '<!--' . LF;
						echo INDENT . TAB . TAB . TAB . TAB . TAB . 'display_link("';
						echo $id . '", "' . $mailto . '", "' . $username . '", "' . $hostname . '");' . LF;
						echo INDENT . TAB . TAB . TAB . TAB . '-->' . LF;
						echo INDENT . TAB . TAB . TAB . '</script>' . LF;
						echo INDENT . TAB . TAB . TAB . '<br/>' . LF;
					}
				}
				else
				{
					echo INDENT . TAB . TAB . TAB . '-unknown-' . LF;
				}

				echo INDENT . TAB . TAB . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				mysql_free_result ($emails);

				// Homepage (possibly more than one for a single author)

				$query = "SELECT *
					FROM	author_homepage
					WHERE	author_id='". $_GET ['id'] . "'";

				$urls = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($urls) != 0)
				{
					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>Homepage</th>' . LF;

					echo INDENT . TAB . TAB . '<td>';
					while ($url = mysql_fetch_assoc ($urls))
					{
						if ($url ['status'] == 'none' )
						{
							echo '-none-<br/>';
						}
						elseif ($url ['status'] == 'bad' )
						{
							echo htmlspecialchars($url ['homepage']) . ' (bad)<br/>';
						}
						else
						{
							echo '<a href="' . htmlspecialchars($url ['homepage']) . '">';
							echo htmlspecialchars($url ['homepage']) . '</a><br/>';
						}
					}
					echo INDENT . TAB . TAB . '</td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';
				}

				mysql_free_result ($urls);

				// Info

				if (isset($row ['info']))
				{
					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>Info</th>' . LF;
					echo INDENT . TAB . TAB . '<td>' . $row ['info'] . '</td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';
				}

				// End of table

				echo INDENT . '</table>' . LF;

				// Emulators

				function list_emulators($id, $title, $relationship)
				{
					$query = "SELECT emulator.*
						FROM	emulator, author_emulator_link
						WHERE	author_emulator_link.emulator_id=emulator.emulator_id and
							author_emulator_link.author_id='" . $id . "' and
							author_emulator_link.relationship='" . $relationship . "'
						ORDER BY name";

					$emulators = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($emulators) != 0)
					{
						echo INDENT . '<h2>' . $title . '</h2>' . LF . LF;
						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="emulator"/>' . LF;
						echo INDENT . TAB . '<colgroup class="platform"/>' . LF;
						echo INDENT . TAB . '<colgroup class="version"/>' . LF . LF;
						echo INDENT . TAB . '<colgroup class="date"/>' . LF . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Emulator</th>' . LF;
						echo INDENT . TAB . TAB . '<th>Platform</th>' . LF;
						echo INDENT . TAB . TAB . '<th>Version</th>' . LF;
						echo INDENT . TAB . TAB . '<th>Date</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($emulator = mysql_fetch_assoc ($emulators))
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<td>';
							echo '<b><a href="emulator.php?id=' . $emulator ['emulator_id'] . '">';
							echo $emulator ['name'] . '</a></b><br/>';
							echo $emulator ['emulates'] . '</td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . $emulator ['platform'] . '</td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . $emulator ['version'] . '</td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . $emulator ['date'] . '</td>' . LF;

							echo INDENT . TAB . '</tr>' . LF;

							$class = ($class == 'even') ? 'odd' : 'even';
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($emulators);
				}

				list_emulators ($_GET ['id'], "Emulators", "author");
				list_emulators ($_GET ['id'], "Contributions", "contributor");

				// Libraries

				function list_libraries($id, $title, $type)
				{
					$query = "SELECT library.*
						FROM	library, author_library_link
						WHERE	author_library_link.library_id=library.library_id and
							author_library_link.author_id='" . $id . "' and
							library.library_contents_id='" . $type . "'
						ORDER BY name";

					$libraries = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($libraries) != 0)
					{
						echo INDENT . '<h2>' . $title . '</h2>' . LF . LF;
						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="library"/>' . LF;
						echo INDENT . TAB . '<colgroup class="version"/>' . LF . LF;
						echo INDENT . TAB . '<colgroup class="date"/>' . LF . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Name</th>' . LF;
						echo INDENT . TAB . TAB . '<th>Version</th>' . LF;
						echo INDENT . TAB . TAB . '<th>Date</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($library = mysql_fetch_assoc ($libraries))
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<td>';
							echo '<b><a href="library.php?id=' . $library ['library_id'] . '">';
							echo $library ['name'] . '</a></b><br/>';
							echo $library ['emulates'] . '</td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . $library ['version'] . '</td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . $library ['date'] . '</td>' . LF;

							echo INDENT . TAB . '</tr>' . LF;

							$class = ($class == 'even') ? 'odd' : 'even';
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($libraries);
				}

				list_libraries ($_GET ['id'], "CPU Cores", "cpu");
				list_libraries ($_GET ['id'], "Sound Emulators", "snd");

				// Tools

				$query = "SELECT tool.*
					FROM	tool, author_tool_link
					WHERE	author_tool_link.tool_id=tool.tool_id and
						author_tool_link.author_id='" . $_GET ['id'] . "'
					ORDER BY name";

				$tools = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($tools) != 0)
				{
					echo INDENT . '<h2>Development Tools</h2>' . LF . LF;
					echo INDENT . '<table class="links">' . LF;
					echo INDENT . TAB . '<colgroup class="tool"/>' . LF;
					echo INDENT . TAB . '<colgroup class="version"/>' . LF . LF;
					echo INDENT . TAB . '<colgroup class="date"/>' . LF . LF;

					echo INDENT . TAB . '<tr>' . LF;
					echo INDENT . TAB . TAB . '<th>Name</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Version</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Date</th>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = 'odd';

					while ($tool = mysql_fetch_assoc ($tools))
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
						echo INDENT . TAB . TAB . '<td>';
						echo '<b><a href="tool.php?id=' . $tool ['tool_id'] . '">';
						echo $tool ['name'] . '</a></td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . $tool ['version'] . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . $tool ['date'] . '</td>' . LF;

						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysql_free_result ($tools);

				// End of page

				mysql_free_result ($result);
			}
			else
			{
				echo INDENT . 'Invalid id has been passed as a parameter, check the URL!' . LF;

				mysql_free_result ($result);
			}

			// Standard page footer (XHTML compliance logo)

			include ('../resources/bottom.php');
		?>
	</body>
</html>
