<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../resources/include.php';

			// Display the page title

			$query = 'SELECT name
				FROM author
				WHERE author_id=' . "'" . $_GET ['id'] . "'";

			$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

			if (mysqli_num_rows($result) != 0)
			{
				$row = mysqli_fetch_assoc($result);

				echo '<title>CAESAR - ' . $row ['name'] . '</title>' . LF . LF;
			}
			else
			{
				echo '<title>CAESAR</title>' . LF . LF;
			}

			mysqli_free_result($result);

			// Include standard <head> metadata

			include '../resources/head.php';

			// Include PHP function for creation of text images

			include '../resources/text_image.php';

			// Define the encryption ranges for PHP

			$ENC_MIN = 0x21;
			$ENC_MAX = 0x7e;
			$ENC_MOD = ($ENC_MAX - $ENC_MIN + 1);

			// Define the encryption ranges for Javascript

			echo LF;
			echo TAB . TAB . '<script type="text/javascript">' . LF;
			echo TAB . TAB . TAB . '<!--' . LF;
			echo TAB . TAB . TAB . TAB . 'id = "'  . $_GET ['id'] . '";' . LF . LF;
			echo TAB . TAB . TAB . TAB . 'ENC_MIN = '  . $ENC_MIN . ';' . LF;
			echo TAB . TAB . TAB . TAB . 'ENC_MAX = '  . $ENC_MAX . ';' . LF;
			echo TAB . TAB . TAB . TAB . 'ENC_MOD = '  . $ENC_MOD . ';' . LF;
			echo TAB . TAB . TAB . '-->' . LF;
			echo TAB . TAB . '</script>' . LF;
		?>

		<script type="text/javascript">
			<!--
    				function decrypt(inSt)
				{
					key = id;

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

				function encrypted_href(image, scheme, hostname)
				{
					scheme = decrypt(scheme);
					hostname = decrypt(hostname);
					document.write('<a href=\"' + scheme + hostname + '\"><img src=\"' + image + '\"/></a>');
				}
			//-->
		</script>
	</head>
	<body>
		<?php
			// Encryption function for e-mail addresses

			function encrypt($inSt)
			{
				global $ENC_MIN;
				global $ENC_MAX;
				global $ENC_MOD;

				$key = 	$_GET ['id'];

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

			include '../resources/top.php';

			// Select the page title and comment

			$query = 'SELECT *
				FROM author
				WHERE author_id=' . "'" . $_GET ['id'] . "'";

			$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

			// If no rows were found, the id was invalid (or unspecified)

			if (mysqli_num_rows($result) != 0)
			{
				// Title and comment

				$row = mysqli_fetch_assoc($result);

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

				$emails = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
				echo INDENT . TAB . TAB . '<th>E-mail</th>' . LF;

				echo INDENT . TAB . TAB . '<td>' . LF;

				if (mysqli_num_rows($emails) != 0)
				{
					if (stripos($_SERVER["HTTP_REFERER"], "caesar") != False)
					{	
						while ($email = mysqli_fetch_assoc($emails))
						{
							$scheme = encrypt('mailto:');
							$hostname = encrypt($email ['email']);
							$image = text_image($email ['email']);

							echo INDENT . TAB . TAB . TAB . '<script type="text/javascript">' . LF;
							echo INDENT . TAB . TAB . TAB . TAB . '<!--' . LF;
							echo INDENT . TAB . TAB . TAB . TAB . TAB . 'encrypted_href("' . $image . '", "' . $scheme . '", "' . $hostname . '");' . LF;
							echo INDENT . TAB . TAB . TAB . TAB . '-->' . LF;
							echo INDENT . TAB . TAB . TAB . '</script>' . LF;
							echo INDENT . TAB . TAB . TAB . '<noscript>' . LF;
							echo INDENT . TAB . TAB . TAB . TAB . '<img src="' . $image . '"/>' . LF;
							echo INDENT . TAB . TAB . TAB . '</noscript>' . LF;
							echo INDENT . TAB . TAB . TAB . '<br/>' . LF;
						}
					}
					else
					{
						echo "-withheld-";
					}
				}
				else
				{
					echo INDENT . TAB . TAB . TAB . '-unknown-' . LF;
				}

				echo INDENT . TAB . TAB . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				mysqli_free_result($emails);

				// Homepage (possibly more than one for a single author)

				$query = "SELECT *
					FROM	author_homepage
					WHERE	author_id='". $_GET ['id'] . "'";

				$urls = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				if (mysqli_num_rows($urls) != 0)
				{
					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>Homepage</th>' . LF;

					echo INDENT . TAB . TAB . '<td>';
					while ($url = mysqli_fetch_assoc($urls))
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

				mysqli_free_result($urls);

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

				function list_emulators($id, $title, $relationship, $mysqli)
				{
					$query = "SELECT emulator.*
						FROM	emulator, author_emulator_link
						WHERE	author_emulator_link.emulator_id=emulator.emulator_id and
							author_emulator_link.author_id='" . $id . "' and
							author_emulator_link.relationship='" . $relationship . "'
						ORDER BY name";

					$emulators = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

					if (mysqli_num_rows($emulators) != 0)
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

						while ($emulator = mysqli_fetch_assoc($emulators))
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

					mysqli_free_result($emulators);
				}

				list_emulators ($_GET ['id'], "Emulators", "author", $mysqli);
				list_emulators ($_GET ['id'], "Contributions", "contributor", $mysqli);

				// Libraries

				function list_libraries($id, $title, $type, $mysqli)
				{
					$query = "SELECT library.*
						FROM	library, author_library_link
						WHERE	author_library_link.library_id=library.library_id and
							author_library_link.author_id='" . $id . "' and
							library.library_contents_id='" . $type . "'
						ORDER BY name";

					$libraries = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

					if (mysqli_num_rows($libraries) != 0)
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

						while ($library = mysqli_fetch_assoc($libraries))
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

					mysqli_free_result($libraries);
				}

				list_libraries ($_GET ['id'], "CPU Cores", "cpu", $mysqli);
				list_libraries ($_GET ['id'], "Sound Emulators", "snd", $mysqli);

				// Tools

				$query = "SELECT tool.*
					FROM	tool, author_tool_link
					WHERE	author_tool_link.tool_id=tool.tool_id and
						author_tool_link.author_id='" . $_GET ['id'] . "'
					ORDER BY name";

				$tools = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				if (mysqli_num_rows($tools) != 0)
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

					while ($tool = mysqli_fetch_assoc($tools))
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

				mysqli_free_result($tools);

				// End of page

				mysqli_free_result($result);
			}
			else
			{
				echo INDENT . 'Invalid id has been passed as a parameter, check the URL!' . LF;

				mysqli_free_result($result);
			}

			// Standard page footer (XHTML compliance logo)

			include '../resources/bottom.php';
		?>
	</body>
</html>
