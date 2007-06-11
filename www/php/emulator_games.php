<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Display the page title

			$query = 'SELECT name
				FROM emulator
				WHERE emulator_id=' . "'" . $_GET ['id'] . "'";

			$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

			if (mysql_num_rows ($result) != 0)
			{
				$row = mysql_fetch_assoc ($result);

				echo '<title>CAESAR - ' . $row ['name'] . ' - Games: ' . $_GET ['letter'] . '</title>' . LF . LF;
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
				FROM emulator
				WHERE emulator_id=' . "'" . $_GET ['id'] . "'";

			$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

			// If no rows were found, the id was invalid (or unspecified)

			if (mysql_num_rows ($result) != 0)
			{
				$row = mysql_fetch_assoc ($result);

				echo INDENT . '<h2>' . $row ['name'] . '</h2>' . LF;
				echo INDENT . '<h2>Games: ' . $_GET ['letter'] . '</h2>' . LF . LF;

				// Games

				$query = "SELECT *
					FROM	game
					WHERE	dat='". $row ['dat'] . "'
					AND	x_hidden_ind IS NULL";

				if ($_GET ['letter'] == '0-9')
				{
					$query = $query . " AND	UPPER(LEFT(game.description, 1))<'A'";
				}
				else
				{
					$query = $query . " AND	UPPER(LEFT(game.description, 1))='" . $_GET ['letter'] . "'";
				}

				$query = $query . " ORDER BY description";

				$games = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($games) != 0)
				{
					echo INDENT . '<table class="links">' . LF;
					echo INDENT . TAB . '<colgroup class="name"/>' . LF;
					echo INDENT . TAB . '<colgroup class="manufacturer"/>' . LF;
					echo INDENT . TAB . '<colgroup class="year"/>' . LF;
					if ($_GET ['id'] != 'mame')
						echo INDENT . TAB . '<colgroup class="nonmame"/>' . LF;

					echo INDENT . TAB . '<tr>' . LF;
					echo INDENT . TAB . TAB . '<th>Name</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Manufacturer</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Year</th>' . LF;
					if ($_GET ['id'] != 'mame')
						echo INDENT . TAB . TAB . '<th>Non MAME?</th>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = 'odd';

					while ($game = mysql_fetch_assoc ($games))
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
						echo INDENT . TAB . TAB . '<td><a href="emulator_game.php?id=' .
							$_GET ['id'] . '&amp;game=' .
							$game ['game_name'] . '">' . htmlspecialchars($game ['description']) . '</a></td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . htmlspecialchars($game ['manufacturer']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . $game ['year'] . '</td>' . LF;
						if ($_GET ['id'] != 'mame')
							echo INDENT . TAB . TAB . '<td>' . ($game ['x_nonmame_ind']==1 ? 'Yes' : '-') . '</td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysql_free_result ($games);

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
