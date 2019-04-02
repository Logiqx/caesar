<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Display the page title

			$query = 'SELECT title
				FROM library_contents
				WHERE library_contents_id=' . "'" . $_GET ['id'] . "'";

			$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

			if (mysqli_num_rows($result) != 0)
			{
				$row = mysqli_fetch_assoc($result);

				echo '<title>CAESAR - ' . $row ['title'] . '</title>' . LF . LF;
			}
			else
			{
				echo '<title>CAESAR</title>' . LF . LF;
			}

			mysqli_free_result($result);

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
				FROM library_contents
				WHERE library_contents_id=' . "'" . $_GET ['id'] . "'";

			$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

			// If no rows were found, the id was invalid (or unspecified)

			if (mysqli_num_rows($result) != 0)
			{
				// Title and comment

				$row = mysqli_fetch_assoc($result);

				echo INDENT . '<h2>' . $row ['title'] . '</h2>' . LF . LF;
				echo INDENT . '<p>' . $row ['comment'] . '</p>' . LF . LF;

				mysqli_free_result($result);

				// Create table for the links and define the column groups

				echo INDENT . '<table class="links">' . LF;

				echo INDENT . TAB . '<colgroup class="library"/>' . LF;
				echo INDENT . TAB . '<colgroup class="author"/>' . LF;
				echo INDENT . TAB . '<colgroup class="version"/>' . LF;
				echo INDENT . TAB . '<colgroup class="date"/>' . LF . LF;

				echo INDENT . TAB . '<tr>' . LF;
				echo INDENT . TAB . TAB . '<th>Tool</th>' . LF;
				echo INDENT . TAB . TAB . '<th>Author</th>' . LF;
				echo INDENT . TAB . TAB . '<th>Version</th>' . LF;
				echo INDENT . TAB . TAB . '<th>Date</th>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				// Select the libraries

				$query = "SELECT library.library_id, name, emulates, version, date
					FROM	library_contents_library_link, library
					WHERE	library_contents_library_link.library_contents_id='" . $_GET ['id'] . "' and
						library_contents_library_link.library_id=library.library_id
					ORDER BY library.name";

				$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				$class = 'odd';

				while ($row = mysqli_fetch_assoc($result))
				{
					// Emulator and platform

					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<td>';
					echo '<b><a href="library.php?id=' . $row ['library_id'] . '">';
					echo $row ['name'] . '</a></b><br/>';
					echo '<small>' . $row ['emulates'] . '</small></td>' . LF;

					// Authors (possibly more than one for a single emulator)

					echo INDENT . TAB . TAB . '<td>';
					$query = "SELECT author.author_id, name
						FROM	library_author_link, author
						WHERE	library_author_link.library_id='". $row ['library_id'] . "' and
							library_author_link.author_id=author.author_id
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

				mysqli_free_result($result);
			}
			else
			{
				echo INDENT . 'Invalid id has been passed as a parameter, check the URL!' . LF;

				mysqli_free_result($result);
			}

			// Standard page footer (XHTML compliance logo)

			include ('../resources/bottom.php');
		?>
	</body>
</html>
