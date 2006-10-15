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
				FROM emulator
				WHERE emulator_id=' . "'" . $_GET ['id'] . "'";

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
				echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($row ['version']) . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				// Date

				echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
				echo INDENT . TAB . TAB . '<th>Date</th>' . LF;
				echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($row ['date']) . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				// Platform

				echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
				echo INDENT . TAB . TAB . '<th>Platform</th>' . LF;
				echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($row ['platform']) . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				// Homepage (possibly more than one for a single emulator)

				$query = "SELECT *
					FROM	emulator_homepage
					WHERE	emulator_id='". $_GET ['id'] . "'";

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

				// Authors (possibly more than one for a single emulator)

				$query = "SELECT *
					FROM	emulator_author_link, author
					WHERE	emulator_author_link.emulator_id='". $_GET ['id'] . "' and
						emulator_author_link.author_id=author.author_id and
						emulator_author_link.relationship='author'
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
				echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($row ['emulates']) . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				// Comment

				echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
				echo INDENT . TAB . TAB . '<th>Comment</th>' . LF;
				echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($row ['comment']) . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				// Status

				echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
				echo INDENT . TAB . TAB . '<th>Status</th>' . LF;
				echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($row ['status']) . '</td>' . LF;
				echo INDENT . TAB . '</tr>' . LF;

				$class = ($class == 'even') ? 'odd' : 'even';

				// CPU Libraries

				$query = "SELECT *
					FROM	emulator_library_link, library
					WHERE	emulator_library_link.emulator_id='". $_GET ['id'] . "' and
						emulator_library_link.library_id=library.library_id and
						library.library_contents_id='cpu'
					ORDER BY name";

				$libs = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($libs) != 0)
				{
					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>CPU Cores</th>' . LF;

					echo INDENT . TAB . TAB . '<td>';
					while ($lib = mysql_fetch_assoc ($libs))
					{
						echo '<a href="library.php?id=' . $lib ['library_id'] . '">';
						echo $lib ['name'] . '</a><br/>';
					}
					echo '</td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';
				}

				mysql_free_result ($libs);

				// Tools

				$query = "SELECT *
					FROM	emulator_tool_link, tool
					WHERE	emulator_tool_link.emulator_id='". $_GET ['id'] . "' and
						emulator_tool_link.tool_id=tool.tool_id
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

				// Features

				$query = "SELECT *
					FROM	emulator_features
					WHERE	emulator_id='". $_GET ['id'] . "'";

				$features = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($features) != 0)
				{
					echo INDENT . '<h2>Features</h2>' . LF . LF;

					echo INDENT . '<table class="details">' . LF;

					echo INDENT . TAB . '<tr>' . LF;
					echo INDENT . TAB . TAB . '<th>Sound</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Source</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Screen Dump</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Hiscore Save</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Save Game</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Record Input</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Dips</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Cheat</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Auto Frameskip</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Throttle</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Network Play</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Record Sound</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Screen Rotate</th>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = 'odd';

					while ($feature = mysql_fetch_assoc ($features))
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['sound']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['source']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['screendump']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['hiscoresave']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['savegame']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['recordinput']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['dips']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['cheat']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['autoframeskip']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['throttle']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['network']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['recordsound']) . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ifnull_qmark($feature ['rotate']) . '</td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysql_free_result ($features);

				// Contributors

				$query = "SELECT *
					FROM	emulator_author_link, author
					WHERE	emulator_author_link.emulator_id='". $_GET ['id'] . "' and
						emulator_author_link.author_id=author.author_id and
						emulator_author_link.relationship='contributor'
					ORDER BY name";

				$contributors = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($contributors) != 0)
				{
					echo INDENT . '<h2>Contributors</h2>' . LF . LF;

					echo INDENT . '<table class="links">' . LF;
					echo INDENT . TAB . '<colgroup class="name"/>' . LF;
					echo INDENT . TAB . '<colgroup class="contributed"/>' . LF;

					echo INDENT . TAB . '<tr>' . LF;
					echo INDENT . TAB . TAB . '<th>Name</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Contributed</th>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = 'odd';

					while ($contributor = mysql_fetch_assoc ($contributors))
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
						echo INDENT . TAB . TAB . '<td><a href="author.php?id=' .
							$contributor ['author_id'] . '">' . $contributor ['name'] . '</a></td>';
						echo INDENT . TAB . TAB . '<td>' . $contributor ['comment'] . '</td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysql_free_result ($contributors);

				// Snaps

				$query = "SELECT *
					FROM	snap
					WHERE	path='emus/" . $row ['emulator_contents_id'] . "' and
						name like '" . $_GET ['id'] . "_%'
					ORDER BY name";

				$snaps = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($snaps) != 0)
				{
					echo INDENT . '<h2>GUI</h2>' . LF . LF;
					echo INDENT . '<p>' . LF . LF;

					while ($snap = mysql_fetch_assoc ($snaps))
					{
						echo INDENT . TAB . '<img src="../snaps/' . $snap ['path'] . '/' .
							$snap ['name'] . '" alt="' . $snap ['name'] .
							'" width="' . $snap ['width'] .
							'" height="' . $snap ['height'] . '"/>' . LF;
					}

					echo INDENT . '</p>' . LF;
				}

				mysql_free_result ($snaps);

				// Relatives

				function list_relatives($id, $title, $relationship)
				{
					$query = "SELECT emulator.*
						FROM	emulator, emulator_relative_link
						WHERE	emulator_relative_link.relative_id=emulator.emulator_id and
							emulator_relative_link.emulator_id='" . $id . "' and
							emulator_relative_link.relationship='" . $relationship . "'
						ORDER BY name";

					$relatives = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($relatives) != 0)
					{
						echo INDENT . '<h2>' . $title . '</h2>' . LF . LF;
						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="emulator"/>' . LF;
						echo INDENT . TAB . '<colgroup class="platform"/>' . LF;
						echo INDENT . TAB . '<colgroup class="author"/>' . LF . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Emulator</th>' . LF;
						echo INDENT . TAB . TAB . '<th>Platform</th>' . LF;
						echo INDENT . TAB . TAB . '<th>Author</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($relative = mysql_fetch_assoc ($relatives))
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<td>';
							echo '<b><a href="emulator.php?id=' . $relative ['emulator_id'] . '">';
							echo $relative ['name'] . '</a></b><br/>';
							echo $relative ['comment'] . '</td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . $relative ['platform'] . '</td>' . LF;

							// Authors (possibly more than one for a single emulator)

							echo INDENT . TAB . TAB . '<td>';
							$query = "SELECT author.author_id, name
								FROM	emulator_author_link, author
								WHERE	emulator_author_link.emulator_id='". $relative ['emulator_id'] . "' and
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

							echo INDENT . TAB . '</tr>' . LF;

							$class = ($class == 'even') ? 'odd' : 'even';
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($relatives);
				}

				list_relatives ($_GET ['id'], "Predecessors", "predecessor");
				list_relatives ($_GET ['id'], "Derivative Of", "derivative_of");
				list_relatives ($_GET ['id'], "Hybrid Of", "hybrid_of");
				list_relatives ($_GET ['id'], "Modifiction Of", "modification_of");
				list_relatives ($_GET ['id'], "Port Of", "port_of");
				list_relatives ($_GET ['id'], "Alternative Versions", "alt_version");
				list_relatives ($_GET ['id'], "Ports", "port");
				list_relatives ($_GET ['id'], "Modified Versions", "modified_version");
				list_relatives ($_GET ['id'], "Derivatives", "derivative");
				list_relatives ($_GET ['id'], "Successors", "successor");

				// Downloads

				$query = "SELECT *
					FROM	emulator_file, zip
					WHERE	emulator_id='". $_GET ['id'] . "'
					AND	zip.path=concat('emus/', '" . $row ['emulator_contents_id'] . "', '/', '" . $_GET ['id'] . "')
					AND	zip.name=emulator_file.name";

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
						echo INDENT . TAB . TAB . '<td><a href="../zips/emus/' .
							$row ['emulator_contents_id'] . '/' . $_GET ['id'] . '/' .
							$file ['name'] . '">' . $file ['name'] . '</a></td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . $file ['description'] . '</td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . ceil($file ['bytes'] / 1024) . 'KB</td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysql_free_result ($files);

				// Games

				echo INDENT . '<h2>Emulated Games</h2>' . LF . LF;

				$query = "SELECT *
					FROM	game
					WHERE	dat='". $row ['dat'] . "'
					AND	x_hidden_ind IS NULL
					ORDER BY description";

				$games = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($games) > 1000)
				{
					echo INDENT . '<p>' . LF;
					echo INDENT . INDENT . '<a href="emulator_games.php?id=' . $_GET ['id'] . '&amp;letter=0-9">0-9</a>';
					for ($c = 'A', $i = 0; $i < 26; $i++, $c++)
					{
						echo INDENT . INDENT . '| <a href="emulator_games.php?id=' . $_GET ['id'] . '&amp;letter=' . $c . '">' . $c . '</a>';
					}
					echo INDENT . '</p>' . LF;
				}
				elseif (mysql_num_rows ($games) != 0)
				{
					echo INDENT . '<table class="links">' . LF;
					echo INDENT . TAB . '<colgroup class="name"/>' . LF;
					echo INDENT . TAB . '<colgroup class="manufacturer"/>' . LF;
					echo INDENT . TAB . '<colgroup class="year"/>' . LF;
					echo INDENT . TAB . '<colgroup class="nonmame"/>' . LF;

					echo INDENT . TAB . '<tr>' . LF;
					echo INDENT . TAB . TAB . '<th>Name</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Manufacturer</th>' . LF;
					echo INDENT . TAB . TAB . '<th>Year</th>' . LF;
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
						echo INDENT . TAB . TAB . '<td>' . ($game ['x_nonmame_ind']==1 ? 'Yes' : '-') . '</td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				if ($row ['dat'] == 'empty')
				{
					echo INDENT . '<p>This emulator does not support any games!</p>' . LF . LF;
				}

				if ($row ['dat'] == 'dummy')
				{
					echo INDENT . '<p>For a list of supported games see the main version of the emulator (listed above).</p>' . LF . LF;
				}

				if (isset($row ['dat_type']) && $row ['dat_type'] == 'extra')
				{
					echo INDENT . '<p>Note: This list only shows games that are not in the main version of the emulator (see above).</p>' . LF . LF;
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
