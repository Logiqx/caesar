<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Display the page title

			$query = 'SELECT name
				FROM tool
				WHERE tool_id=' . "'" . $_GET ['id'] . "'";

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
				FROM tool
				WHERE tool_id=' . "'" . $_GET ['id'] . "'";

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

				// Homepage (possibly more than one for a single tool)

				$query = "SELECT *
					FROM	tool_homepage
					WHERE	tool_id='". $_GET ['id'] . "'";

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

				// Authors (possibly more than one for a single tool)

				$query = "SELECT *
					FROM	tool_author_link, author
					WHERE	tool_author_link.tool_id='". $_GET ['id'] . "' and
						tool_author_link.author_id=author.author_id
					ORDER BY name";

				$authors = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				if (mysqli_num_rows($authors) != 0)
				{
					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>Author(s)</th>' . LF;

					echo INDENT . TAB . TAB . '<td>';
					while ($author = mysqli_fetch_assoc($authors))
					{
						echo '<a href="author.php?id=' . $author ['author_id'] . '">';
						echo $author ['name'] . '</a><br/>';
					}
					echo '</td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';
				}

				mysqli_free_result($authors);

				// Comment

				echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
				echo INDENT . TAB . TAB . '<th>Comment</th>' . LF;
				echo INDENT . TAB . TAB . '<td>' . $row ['comment'] . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				// End of table

				echo INDENT . '</table>' . LF;

				// Emulators

				$query = "SELECT *
					FROM	tool_emulator_link, emulator
					WHERE	tool_emulator_link.tool_id='". $_GET ['id'] . "' and
						tool_emulator_link.emulator_id=emulator.emulator_id
					ORDER BY name";

				$emus = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				if (mysqli_num_rows($emus) != 0)
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

					while ($emu = mysqli_fetch_assoc($emus))
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

						$authors = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

						while ($author = mysqli_fetch_assoc($authors))
						{
							echo '<a href="author.php?id=' . $author ['author_id'] . '">';
							echo $author ['name'] . '</a><br/>';
						}
						echo '</td>' . LF;

						echo INDENT . TAB . '</tr>' . LF;

						mysqli_free_result($authors);

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysqli_free_result($emus);

				// Libraries

				$query = "SELECT *
					FROM	tool_library_link, library
					WHERE	tool_library_link.tool_id='". $_GET ['id'] . "' and
						tool_library_link.library_id=library.library_id
					ORDER BY name";

				$libs = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				if (mysqli_num_rows($libs) != 0)
				{
					echo INDENT . '<h2>Used by these Libraries</h2>' . LF . LF;

					echo INDENT . '<table class="links">' . LF;
					echo INDENT . TAB . '<colgroup class="library"/>' . LF;
					echo INDENT . TAB . '<colgroup class="author"/>' . LF;

					echo INDENT . TAB . '<tr>' . LF;
					echo INDENT . TAB . TAB . '<th>Library</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Author</th>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = 'odd';

					while ($lib = mysqli_fetch_assoc($libs))
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
						echo INDENT . TAB . TAB . '<td><b><a href="library.php?id=' .
							$lib ['library_id'] . '">' . $lib ['name'] . '</a></b><br/>';
						echo $lib ['emulates'] . '</td>' . LF;

						// Authors (possibly more than one for a single library)

						echo INDENT . TAB . TAB . '<td>';
						$query = "SELECT author.author_id, name
							FROM	library_author_link, author
							WHERE	library_author_link.library_id='". $lib ['library_id'] . "' and
								library_author_link.author_id=author.author_id
							ORDER BY name";

						$authors = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

						while ($author = mysqli_fetch_assoc($authors))
						{
							echo '<a href="author.php?id=' . $author ['author_id'] . '">';
							echo $author ['name'] . '</a><br/>';
						}
						echo '</td>' . LF;

						echo INDENT . TAB . '</tr>' . LF;

						mysqli_free_result($authors);

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysqli_free_result($libs);

				// Downloads

				$query = "SELECT *
					FROM	tool_file, zip
					WHERE	tool_id='". $_GET ['id'] . "'
					AND	zip.path=concat('tools/', '" . $row ['tool_contents_id'] . "', '/', '" . $_GET ['id'] . "')
					AND	zip.name=tool_file.name";

				$files = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				if (mysqli_num_rows($files) != 0)
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

					while ($file = mysqli_fetch_assoc($files))
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
						echo INDENT . TAB . TAB . '<td><a href="../zips/tools/' .
							$row ['tool_contents_id'] . '/' . $_GET ['id'] . '/' .
							$file ['name'] . '">' . $file ['name'] . '</a></td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . $file ['file'] . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ceil($file ['bytes'] / 1024) . 'KB</td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysqli_free_result($files);

				// End of page

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
