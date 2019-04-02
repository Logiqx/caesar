<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Display the page title

			echo '<title>CAESAR - Sourcefile Search Results</title>' . LF . LF;

			// Include standard <head> metadata

			include ('../resources/head.php');
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the information)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			$menu="games";

			include ('../resources/top.php');

			// Interpret parameters

			if (isset($_GET['file']))
				$file=$_GET['file'];
			else
				$file='';

			if (isset($_GET['file_match']))
				$file_match=$_GET['file_match'];
			else
				$file_match='';

			if (isset($_GET['multiscreen']))
				$multiscreen=$_GET['multiscreen'];
			else
				$multiscreen='';

			if (isset($_GET['sort']))
				$sort=$_GET['sort'];
			else
				$sort='';

			// Display form

			echo INDENT . '<h2>Search Criteria</h2>' . LF . LF;

			echo INDENT . '<form action="sourcefile_search.php" method="get">' . LF;
			echo INDENT . TAB . '<table>' . LF;
			echo INDENT . TAB . TAB . '<tr>' . LF;
			echo INDENT . TAB . TAB . TAB . '<td align="center">' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="file"><strong>Sourcefile</strong></label><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="file" type="text" name="file" value="' . $file . '"/><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="file_match_begins" ' . ($file_match != 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="file_match" value="begins"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="file_match_begins">begins</label>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="file_match_contains" ' . ($file_match == 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="file_match" value="contains"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="file_match_contains">contains</label>' . LF;
			echo INDENT . TAB . TAB . TAB . '</td>' . LF;
			echo INDENT . TAB . TAB . '</tr>' . LF;
			echo INDENT . TAB . TAB . '<tr>' . LF;
			echo INDENT . TAB . TAB . TAB . '<td align="center">' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input type="submit" value="Search"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input type="reset"/>' . LF;
			echo INDENT . TAB . TAB . TAB . '</td>' . LF;
			echo INDENT . TAB . TAB . '</tr>' . LF;
			echo INDENT . TAB . '</table>' . LF;
			echo INDENT . '</form>' . LF;

			// Remember args and construct query

			$args = '';

			$query = 'SELECT distinct game_sourcefile
				FROM game
				WHERE x_master_ind=1
				AND x_hidden_ind IS NULL';

			if ($multiscreen != '')
			{
				if ($args != '' )
					$args = $args . '&amp;';

				$args = $args . 'x_multiscreen=' . $multiscreen;

				$query = $query . " AND x_multiscreen_ind=1";
			}

			if ($file != '')
			{
				if ($args != '' )
					$args = $args . '&amp;';

				$args = $args . 'file=' . $file;

				if ($file_match != '')
					$args = $args . '&amp;file_match=' . $file_match;

				if ($file_match == 'before')
					$query = $query . ' AND game_sourcefile < ' . "'" . strtoupper($file) . "'";
				elseif ($file_match == 'contains')
					$query = $query . ' AND game_sourcefile like ' . "'%" . strtoupper($file) . "%'";
				else
					$query = $query . ' AND game_sourcefile like ' . "'" . strtoupper($file) . "%'";
			}

			if ($sort != '')
			{
				switch ($sort)
				{
					case 'file':
						//echo INDENT . '<p>Sorted by Sourcefile</p>' . LF . LF;
						$query = $query . " ORDER BY game_sourcefile";
						break;
				}
			}
			else
			{
				//echo INDENT . '<p>Sorted by Sourcefile</p>' . LF . LF;
				$query = $query . " ORDER BY game_sourcefile";
			}

			if ($file != '' || $multiscreen != '')
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
					echo INDENT . '<table class="links">' . LF;

					echo INDENT . TAB . '<colgroup class="name"/>' . LF;

					echo INDENT . TAB . '<tr>' . LF;
					echo INDENT . TAB . TAB . '<th><a href="sourcefile_search.php?' . $args . '&amp;sort=file">Sourcefile</a></th>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = 'odd';

					while ($row = mysqli_fetch_assoc($result))
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;

						echo INDENT . TAB . TAB . '<td><a href="game_search.php?sourcefile=';
						echo $row [ 'game_sourcefile' ];
						if ($multiscreen != '')
							echo '&multiscreen=1';
						echo '">' . htmlspecialchars($row ['game_sourcefile']) . '</a></td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysqli_free_result($result);
			}

			// Standard page footer (XHTML compliance logo)

			include ('../resources/bottom.php');
		?>
	</body>
</html>
