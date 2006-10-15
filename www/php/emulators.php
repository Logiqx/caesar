<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Display the page title

			$query = 'SELECT title
				FROM emulator_contents
				WHERE emulator_contents_id=' . "'" . $_GET ['id'] . "'";

			$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

			if (mysql_num_rows ($result) != 0)
			{
				$row = mysql_fetch_assoc ($result);

				echo '<title>CAESAR - ' . $row ['title'] . '</title>' . LF . LF;
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

			$query = 'SELECT title, comment
				FROM emulator_contents
				WHERE emulator_contents_id=' . "'" . $_GET ['id'] . "'";

			$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

			// If no rows were found, the id was invalid (or unspecified)

			if (mysql_num_rows ($result) != 0)
			{
				// Title and comment

				$row = mysql_fetch_assoc ($result);

				echo INDENT . '<h2>' . $row ['title'] . '</h2>' . LF . LF;
				echo INDENT . '<p>' . $row ['comment'] . '</p>' . LF . LF;

				mysql_free_result ($result);

				// Create table for the links and define the column groups

				echo INDENT . '<table class="links">' . LF;

				echo INDENT . TAB . '<colgroup class="emulator"/>' . LF;
				echo INDENT . TAB . '<colgroup class="platform"/>' . LF;
				echo INDENT . TAB . '<colgroup class="author"/>' . LF;
				echo INDENT . TAB . '<colgroup class="version"/>' . LF;
				echo INDENT . TAB . '<colgroup class="date"/>' . LF . LF;

				echo INDENT . TAB . '<tr>' . LF;
				echo INDENT . TAB . TAB . '<th>Emulator</th>' . LF;
				echo INDENT . TAB . TAB . '<th>Platform</th>' . LF;
				echo INDENT . TAB . TAB . '<th>Author</th>' . LF;
				echo INDENT . TAB . TAB . '<th>Version</th>' . LF;
				echo INDENT . TAB . TAB . '<th>Date</th>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				// Select the emulators

				if ($_GET ['id'] == 'oldnames')
				{
					$query = "SELECT emulator_old_name.name old_name, emulator.emulator_id, emulator.name, emulates, platform, version, date
						FROM	emulator_old_name, emulator
						WHERE	emulator_old_name.emulator_id=emulator.emulator_id
						ORDER BY emulator_old_name.name";
				}
				else
				{
					$query = "SELECT emulator.emulator_id, name, emulates, platform, version, date
						FROM	emulator_contents_emulator_link, emulator
						WHERE	emulator_contents_emulator_link.emulator_contents_id='" . $_GET ['id'] . "' and
							emulator_contents_emulator_link.emulator_id=emulator.emulator_id
						ORDER BY emulator.name";
				}

				$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				$class = 'odd';

				while ($row = mysql_fetch_assoc ($result))
				{
					// Emulator and platform

					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<td>';
					if (isset($row ['old_name']))
					{
						echo '<b>' . $row ['old_name'] . '</b><br/>Now: '; 
					}
					echo '<b><a href="emulator.php?id=' . $row ['emulator_id'] . '">';
					echo $row ['name'] . '</a></b><br/>';
					echo '<small>' . $row ['emulates'] . '</small></td>' . LF;
					echo INDENT . TAB . TAB . '<td>' . $row ['platform'] . '</td>' . LF;

					// Authors (possibly more than one for a single emulator)

					echo INDENT . TAB . TAB . '<td>';
					$query = "SELECT author.author_id, name
						FROM	emulator_author_link, author
						WHERE	emulator_author_link.emulator_id='". $row ['emulator_id'] . "' and
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

					mysql_free_result ($authors);

					// Version and date

					echo INDENT . TAB . TAB . '<td>' . $row ['version'] . '</td>' . LF;
					echo INDENT . TAB . TAB . '<td>' . $row ['date'] . '</td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					// Toggle even/odd

					$class = ($class == 'even') ? 'odd' : 'even';
				}

				echo INDENT . '</table>' . LF;

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
