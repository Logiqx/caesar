<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../resources/include.php';

			// Display the page title

			echo '<title>CAESAR - Emulator Search Results</title>' . LF . LF;

			// Include standard <head> metadata

			include '../resources/head.php';
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the information)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			include '../resources/top.php';

			// Interpret parameters

			if (isset($_GET['emulator']))
				$emulator=$_GET['emulator'];
			else
				$emulator='';

			if (isset($_GET['emulator_match']))
				$emulator_match=$_GET['emulator_match'];
			else
				$emulator_match='';

			if (isset($_GET['author']))
				$author=$_GET['author'];
			else
				$author='';

			if (isset($_GET['author_match']))
				$author_match=$_GET['author_match'];
			else
				$author_match='';

			// Display form

			echo INDENT . '<h2>Search Criteria</h2>' . LF . LF;

			echo INDENT . '<form action="emulator_search.php" method="get">' . LF;
			echo INDENT . TAB . '<table>' . LF;
			echo INDENT . TAB . TAB . '<tr>' . LF;

			echo INDENT . TAB . TAB . TAB . '<td align="center">' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="emulator"><strong>Emulator</strong></label><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="emulator" type="text" name="emulator" value="' . $emulator . '"/><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="emulator_match_begins" ' . ($emulator_match != 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="emulator_match" value="begins"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="emulator_match_begins">begins</label>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="emulator_match_contains" ' . ($emulator_match == 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="emulator_match" value="contains"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="emulator_match_contains">contains</label>' . LF;
			echo INDENT . TAB . TAB . TAB . '</td>' . LF;

			echo INDENT . TAB . TAB . TAB . '<td />' . LF;

			echo INDENT . TAB . TAB . TAB . '<td align="center">' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="author"><strong>Author/Contributor</strong></label><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="author" type="text" name="author" value="' . $author . '"/><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="author_match_begins" ' . ($author_match != 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="author_match" value="begins"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="author_match_begins">begins</label>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="author_match_contains" ' . ($author_match == 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="author_match" value="contains"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="author_match_contains">contains</label>' . LF;
			echo INDENT . TAB . TAB . TAB . '</td>' . LF;

			echo INDENT . TAB . TAB . '</tr>' . LF;
			echo INDENT . TAB . TAB . '<tr>' . LF;
			echo INDENT . TAB . TAB . TAB . '<td/>' . LF;
			echo INDENT . TAB . TAB . TAB . '<td align="center">' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input type="submit" value="Search"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input type="reset"/>' . LF;
			echo INDENT . TAB . TAB . TAB . '</td>' . LF;
			echo INDENT . TAB . TAB . TAB . '<td/>' . LF;
			echo INDENT . TAB . TAB . '</tr>' . LF;
			echo INDENT . TAB . '</table>' . LF;
			echo INDENT . '</form>' . LF;

			// Remember args and construct query

			$args = '';

			$query = 'SELECT distinct emulator.*
				FROM emulator, emulator_author_link, author
				WHERE emulator.emulator_id=emulator_author_link.emulator_id
				AND emulator_author_link.author_id=author.author_id';

			if ($emulator != '')
			{
				if ($emulator_match == 'contains')
					$query = $query . ' AND emulator.name like ' . "'%" . strtoupper($emulator) . "%'";
				else
					$query = $query . ' AND emulator.name like ' . "'" . strtoupper($emulator) . "%'";
			}

			if ($author != '')
			{
				if ($author_match == 'contains')
					$query = $query . ' AND author.name like ' . "'%" . strtoupper($author) . "%'";
				else
					$query = $query . ' AND author.name like ' . "'" . strtoupper($author) . "%'";
			}

			$query = $query . " ORDER BY emulator.name";

			if ($emulator != '' || $author != '')
			{
				$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				echo INDENT . '<hr/>' . LF . LF;

				echo INDENT . '<h2>Results</h2>' . LF . LF;

				echo INDENT . '<p>';

				switch (mysqli_num_rows($result))
				{
					case 0:
						echo 'No matches for the search criteria!';
						break;
					case 1:
						echo 'Exactly one match for the search criteria!';
						break;
					default:
						echo mysqli_num_rows($result) . ' matches for the search criteria!';
						break;
				}

				echo '</p>' . LF . LF;

				if (mysqli_num_rows($result) != 0)
				{
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

					$class = 'odd';

					while ($row = mysqli_fetch_assoc($result))
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

						$authors = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

						while ($author = mysqli_fetch_assoc($authors))
						{
							echo '<a href="author.php?id=' . $author ['author_id'] . '">';
							echo $author ['name'] . '</a><br/>';
						}
						echo '</td>' . LF;

						mysqli_free_result($authors);

						// Version and date

						echo INDENT . TAB . TAB . '<td>' . $row ['version'] . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . $row ['date'] . '</td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						// Toggle even/odd

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysqli_free_result($result);
			}

			// Standard page footer (XHTML compliance logo)

			include '../resources/bottom.php';
		?>
	</body>
</html>
