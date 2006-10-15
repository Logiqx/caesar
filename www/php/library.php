<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Display the page title

			$query = 'SELECT name
				FROM library
				WHERE library_id=' . "'" . $_GET ['id'] . "'";

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
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the information)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			include ('../resources/top.php');

			// Select the page title and comment

			$query = 'SELECT *
				FROM library
				WHERE library_id=' . "'" . $_GET ['id'] . "'";

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

				// Version

				echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
				echo INDENT . TAB . TAB . '<th>Version</th>' . LF;
				echo INDENT . TAB . TAB . '<td>' . $row ['version'] . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				// Date

				echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
				echo INDENT . TAB . TAB . '<th>Date</th>' . LF;
				echo INDENT . TAB . TAB . '<td>' . $row ['date'] . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				// Homepage (possibly more than one for a single library)

				$query = "SELECT *
					FROM	library_homepage
					WHERE	library_id='". $_GET ['id'] . "'";

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

				// Authors (possibly more than one for a single library)

				$query = "SELECT *
					FROM	library_author_link, author
					WHERE	library_author_link.library_id='". $_GET ['id'] . "' and
						library_author_link.author_id=author.author_id
					ORDER BY name";

				$authors = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($authors) != 0)
				{
					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>Author(s)</th>' . LF;

					echo INDENT . TAB . TAB . '<td>';
					while ($author = mysql_fetch_assoc ($authors))
					{
						echo '<a href="author.php?id=' . $author ['author_id'] . '">';
						echo $author ['name'] . '</a><br/>';
					}
					echo '</td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';
				}

				mysql_free_result ($authors);

				// Emulates

				echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
				echo INDENT . TAB . TAB . '<th>Emulates</th>' . LF;
				echo INDENT . TAB . TAB . '<td>' . $row ['emulates'] . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				// Comment

				echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
				echo INDENT . TAB . TAB . '<th>Comment</th>' . LF;
				echo INDENT . TAB . TAB . '<td>' . $row ['comment'] . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				// Tools

				$query = "SELECT *
					FROM	library_tool_link, tool
					WHERE	library_tool_link.library_id='". $_GET ['id'] . "' and
						library_tool_link.tool_id=tool.tool_id
					ORDER BY name";

				$tools = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($tools) != 0)
				{
					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>Development Tools</th>' . LF;

					echo INDENT . TAB . TAB . '<td>';
					while ($tool = mysql_fetch_assoc ($tools))
					{
						echo '<a href="tool.php?id=' . $tool ['tool_id'] . '">';
						echo $tool ['name'] . '</a><br/>';
					}
					echo '</td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';
				}

				mysql_free_result ($tools);

				// End of table

				echo INDENT . '</table>' . LF;

				// Emulators

				$query = "SELECT *
					FROM	library_emulator_link, emulator
					WHERE	library_emulator_link.library_id='". $_GET ['id'] . "' and
						library_emulator_link.emulator_id=emulator.emulator_id
					ORDER BY name";

				$emus = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($emus) != 0)
				{
					echo INDENT . '<h2>Used by these Emulators</h2>' . LF . LF;

					echo INDENT . '<table class="links">' . LF;
					echo INDENT . TAB . '<colgroup class="emulator"/>' . LF;
					echo INDENT . TAB . '<colgroup class="platform"/>' . LF;
					echo INDENT . TAB . '<colgroup class="author"/>' . LF;

					echo INDENT . TAB . '<tr>' . LF;
					echo INDENT . TAB . TAB . '<th>Library</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Platform</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Author</th>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = 'odd';

					while ($emu = mysql_fetch_assoc ($emus))
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
						echo INDENT . TAB . TAB . '<td><b><a href="emulator.php?id=' .
							$emu ['emulator_id'] . '">' . $emu ['name'] . '</a></b><br/>';
						echo $emu ['comment'] . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . $emu ['platform'] . '</td>' . LF;

						// Authors (possibly more than one for a single emulator)

						echo INDENT . TAB . TAB . '<td>';
						$query = "SELECT author.author_id, name
							FROM	emulator_author_link, author
							WHERE	emulator_author_link.emulator_id='". $emu ['emulator_id'] . "' and
								emulator_author_link.author_id=author.author_id and
								emulator_author_link.relationship='author'
							ORDER BY name";

						$authors = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

						while ($author = mysql_fetch_assoc ($authors))
						{
							echo '<a href="author.php?id=' . $author ['author_id'] . '">';
							echo $author ['name'] . '</a><br/>';
						}
						echo '</td>' . LF;

						echo INDENT . TAB . '</tr>' . LF;

						mysql_free_result ($authors);

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysql_free_result ($emus);

				// Relatives

				function list_relatives($id, $title, $relationship)
				{
					$query = "SELECT library.*
						FROM	library, library_relative_link
						WHERE	library_relative_link.relative_id=library.library_id and
							library_relative_link.library_id='" . $id . "' and
							library_relative_link.relationship='" . $relationship . "'
						ORDER BY name";

					$relatives = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($relatives) != 0)
					{
						echo INDENT . '<h2>' . $title . '</h2>' . LF . LF;
						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="library"/>' . LF;
						echo INDENT . TAB . '<colgroup class="author"/>' . LF . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Emulator</th>' . LF;
						echo INDENT . TAB . TAB . '<th>Author</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($relative = mysql_fetch_assoc ($relatives))
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<td>';
							echo '<b><a href="library.php?id=' . $relative ['library_id'] . '">';
							echo $relative ['name'] . '</a></b><br/>';
							echo $relative ['emulates'] . '</td>' . LF;

							// Authors (possibly more than one for a single library)

							echo INDENT . TAB . TAB . '<td>';
							$query = "SELECT author.author_id, name
								FROM	library_author_link, author
								WHERE	library_author_link.library_id='". $relative ['library_id'] . "' and
									library_author_link.author_id=author.author_id
								ORDER BY name";

							$authors = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

							while ($author = mysql_fetch_assoc ($authors))
							{
								echo '<a href="author.php?id=' . $author ['author_id'] . '">';
								echo $author ['name'] . '</a><br/>';
							}
							echo '</td>' . LF;

							mysql_free_result ($authors);

							echo INDENT . TAB . '</tr>' . LF;

							$class = ($class == 'even') ? 'odd' : 'even';
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($relatives);
				}

				list_relatives ($_GET ['id'], "Predecessors", "predecessor");
				list_relatives ($_GET ['id'], "Successors", "successor");

				// Downloads

				$query = "SELECT *
					FROM	library_file, zip
					WHERE	library_id='". $_GET ['id'] . "'
					AND	zip.path=concat('libs/', '" . $row ['library_contents_id'] . "', '/', '" . $_GET ['id'] . "')
					AND	zip.name=library_file.name";

				$files = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($files) != 0)
				{
					echo INDENT . '<h2>Downloads</h2>' . LF . LF;

					echo INDENT . '<table class="links">' . LF;
					echo INDENT . TAB . '<colgroup class="filename"/>' . LF;
					echo INDENT . TAB . '<colgroup class="description"/>' . LF;
					echo INDENT . TAB . '<colgroup class="size"/>' . LF;

					echo INDENT . TAB . '<tr>' . LF;
					echo INDENT . TAB . TAB . '<th>Filename</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Description</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Size</th>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = 'odd';

					while ($file = mysql_fetch_assoc ($files))
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
						echo INDENT . TAB . TAB . '<td><a href="../zips/libs/' .
							$row ['library_contents_id'] . '/' . $_GET ['id'] . '/' .
							$file ['name'] . '">' . $file ['name'] . '</a></td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . $file ['file'] . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ceil($file ['bytes'] / 1024) . 'KB</td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysql_free_result ($files);

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
