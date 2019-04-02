<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../resources/include.php';

			// Identify the group name

			$query = "SELECT x_group_name
				FROM game
				WHERE x_master_ind=1
				AND game_name='" . $_GET['id'] . "'";

			$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));
			$row = mysqli_fetch_assoc($result);
			$x_group_name = $row ['x_group_name'];
			mysqli_free_result($result);

			// Fetch the group description

			$query = "SELECT description
				FROM game
				WHERE x_master_ind=1
				AND game_name='" . $x_group_name . "'";

			$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));
			$row = mysqli_fetch_assoc($result);
			$group_desc = htmlspecialchars($row ['description']);
			mysqli_free_result($result);

			// Display the page title

			if ($group_desc != '')
				echo '<title>CAESAR - ' . $group_desc . '</title>' . LF . LF;
			else
				echo '<title>CAESAR - Unknown Game!</title>' . LF . LF;

			// Include standard <head> metadata

			include '../resources/head.php';
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the information)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			$menu="games";

			include '../resources/top.php';

			// Process the parent

			if ($x_group_name != '')
			{
				// Identify all of the clones

				$query = "SELECT *
					FROM game
					WHERE x_master_ind=1
					AND x_group_name='" . $x_group_name . "'
					AND x_hidden_ind IS NULL
					ORDER BY description";

				$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				while ($row = mysqli_fetch_assoc($result))
				{
					// Display description

					echo INDENT . '<h2><a name="' . $row ['game_name'] . '">' . htmlspecialchars($row ['description']) . '</a></h2>' . LF;

					echo INDENT . '<p>';

					// Check for category

					$query = 'SELECT *
						FROM catver
						WHERE game_name=' . "'" . $row ['game_name'] . "'";

					$catver = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

					if (mysqli_num_rows($catver) != 0)
					{
						$catver_row = mysqli_fetch_assoc($catver);

						echo $catver_row ['category'] . ' - ';
					}

					mysqli_free_result($catver);

					// Display manufacturer and year

					echo htmlspecialchars($row ['manufacturer']) . ', ' . $row ['year'] . '.';

					if ($row ['x_nonmame_ind'] == 1)
						echo INDENT . '<i>Not supported by current release of MAME</i>';

					// Check for history

					$query = 'SELECT history_id
						FROM history_link
						WHERE history_link.game_name=' . "'" . $row ['game_name'] . "'";

					$history = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

					if (mysqli_num_rows($history) != 0)
					{
						echo ' - read <a href="history.php?id=' . $row ['game_name'] . '">history</a>';
					}

					mysqli_free_result($history);

					// Main info done!

					echo '</p>' . LF;

					// Marquees

					$query = "SELECT *
						FROM	image
						WHERE	path='marquees' AND
							name='" . $row ['game_name'] . ".png'";

					$marquees = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

					while ($marquee = mysqli_fetch_assoc($marquees))
					{
						echo INDENT . '<p><img src="../images/' . $marquee ['path'] . '/' .
							$marquee ['name'] . '" alt="' . $marquee ['name'] .
							'" width="' . $marquee ['width'] .
							'" height="' . $marquee ['height'] . '"/></p>' . LF;
					}

					mysqli_free_result($marquees);

					// Emulators supporting the clone

					$query = "SELECT *
						FROM game, emulator
						WHERE x_map_name='" . $row ['game_name'] . "'
						AND game.dat=emulator.dat
						AND game.x_hidden_ind IS NULL
						ORDER BY description";

					$games = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

					if (mysqli_num_rows($games) != 0)
					{
						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="game"/>' . LF;
						echo INDENT . TAB . '<colgroup class="emulator"/>' . LF;
						echo INDENT . TAB . '<colgroup class="platform"/>' . LF . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Game</th>' . LF;
						echo INDENT . TAB . TAB . '<th>Emulator</th>' . LF;
						echo INDENT . TAB . TAB . '<th>Platform</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($game = mysqli_fetch_assoc($games))
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<td>';
							echo '<a href="emulator_game.php?id=' . $game ['emulator_id'];
							echo '&amp;game=' . $game ['game_name'] . '">';
							echo htmlspecialchars($game ['description']) . '</a></td>' . LF;
							echo INDENT . TAB . TAB . '<td>';
							echo '<a href="emulator.php?id=' . $game ['emulator_id'] . '">';
							echo $game ['name'] . '</a></td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . $game ['platform'] . '</td>' . LF;

							echo INDENT . TAB . '</tr>' . LF;

							$class = ($class == 'even') ? 'odd' : 'even';
						}

						echo INDENT . '</table>' . LF;
					}

					mysqli_free_result($games);
				}

				mysqli_free_result($result);

				// Flyers

				$query = "SELECT image.*
					FROM game, image
					WHERE x_master_ind=1
					AND image.path='flyers'
					AND image.name=concat(game.game_name, '.png')
					AND game.x_group_name='" . $x_group_name . "'
					ORDER BY description";

				$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				if (mysqli_num_rows($result) != 0)
				{
					echo INDENT . '<p>' . LF;

					while ($row = mysqli_fetch_assoc($result))
					{
						echo INDENT . '<img src="../images/' . $row ['path'] . '/' .
							$row ['name'] . '" alt="' . $row ['name'] .
							'" width="' . $row ['width'] .
							'" height="' . $row ['height'] . '"/> ';
					}

					echo INDENT . '</p>' . LF;
				}

				mysqli_free_result($result);

				// Cabinets

				$query = "SELECT image.*
					FROM game, image
					WHERE x_master_ind=1
					AND image.path='cabinets'
					AND image.name=concat(game.game_name, '.png')
					AND x_group_name='" . $x_group_name . "'
					ORDER BY description";

				$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				if (mysqli_num_rows($result) != 0)
				{
					echo INDENT . '<p>' . LF;

					while ($row = mysqli_fetch_assoc($result))
					{
						echo INDENT . '<img src="../images/' . $row ['path'] . '/' .
							$row ['name'] . '" alt="' . $row ['name'] .
							'" width="' . $row ['width'] .
							'" height="' . $row ['height'] . '"/> ';
					}

					echo INDENT . '</p>' . LF;
				}

				mysqli_free_result($result);
			}
			else
			{
				echo INDENT . 'An unrecognised game name was passed in as a parameter!' . LF;
			}

			// Standard page footer (XHTML compliance logo)

			include '../resources/bottom.php';
		?>
	</body>
</html>
