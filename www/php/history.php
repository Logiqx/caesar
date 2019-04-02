<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../resources/include.php';

			// Display the page title

			$query = 'SELECT description
				FROM game
				WHERE x_master_ind=1 and game_name=' . "'" . $_GET ['id'] . "'";

			$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

			if (mysqli_num_rows($result) != 0)
			{
				$row = mysqli_fetch_assoc($result);

				$title = $row ['description'];
			}
			else
			{
				$title = $_GET ['id'];
			}

			echo '<title>CAESAR - ' . $title . '</title>' . LF . LF;

			mysqli_free_result($result);

			// Include standard <head> metadata

			include '../resources/head.php';
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the information)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			include '../resources/top.php';
			
			// Show title

			echo '<h2>' . $title . '</h2>' . LF . LF;

			// Select history text

			$query = 'SELECT text
				FROM history_link, history_text
				WHERE history_link.game_name=' . "'" . $_GET ['id'] . "'" . ' AND
				history_text.history_id=history_link.history_id
				ORDER BY history_text.line_no';

			$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

			if (mysqli_num_rows($result) != 0)
			{
				echo INDENT . '<table class="news"><tr><td>' . LF;

				while ($row = mysqli_fetch_assoc($result))
				{
					echo INDENT . TAB . htmlspecialchars($row ['text']) . '<br />' . LF;
				}

				echo INDENT . '</td></tr></table>' . LF;
			}
			else
			{
				echo INDENT . 'Invalid id has been passed as a parameter, check the URL!' . LF;
			}

			mysqli_free_result($result);

			// Standard page footer (XHTML compliance logo)

			include '../resources/bottom.php';
		?>
	</body>
</html>

