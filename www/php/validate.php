<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../resources/include.php';

			// Display the page title

			echo '<title>CAESAR - Validation</title>' . LF . LF;

			// Include standard <head> metadata

			include '../resources/head.php';

			// Include PHP function for creation of text images

			include '../resources/text_image.php';
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the information)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			$menu="validate";

			include '../resources/top.php';

			function run_query($query, $comment, $num_cols)
			{
				$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				$count = mysqli_num_rows($result);

				echo INDENT . '<p><b>' . $comment . ' (' . $count . ')</b></p>' . LF . LF;

				if ($count != 0)
				{
					echo INDENT . '<table class="details">' . LF;

					$class = 'odd';

					while ($row = mysqli_fetch_row($result))
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;

						for ($i = 0; $i < $num_cols; $i++)
						{
							echo INDENT . TAB . TAB . '<td>' . $row [$i] . '</td>' . LF;
						}

						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF . LF;
				}
				else
				{
					echo INDENT . '<p>None</p>' . LF . LF;
				}

				mysqli_free_result($result);
			}

			if (isset($_GET ['type']) && $_GET ['type']=='authors')
			{
				$query="
					SELECT author_id FROM author
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM author_emulator_link
						WHERE author.author_id=author_emulator_link.author_id
					)
					AND NOT EXISTS
					(
						SELECT 1
						FROM author_tool_link
						WHERE author.author_id=author_tool_link.author_id
					)
					AND NOT EXISTS
					(
						SELECT 1
						FROM author_library_link
						WHERE author.author_id=author_library_link.author_id
					)
					";

				run_query($query, "Unused authors (not in author_emulator_link, author_tool_link, author_library_link)", 1);

				$query="
					SELECT *
					FROM author_emulator_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM emulator_author_link
						WHERE emulator_author_link.author_id=author_emulator_link.author_id
						AND emulator_author_link.emulator_id=author_emulator_link.emulator_id
						AND emulator_author_link.relationship=author_emulator_link.relationship
					)
					";

				run_query($query, "author_emulator_link without an emulator_author_link", 3);

				$query="
					SELECT *
					FROM author_library_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM library_author_link
						WHERE library_author_link.author_id=author_library_link.author_id
						AND library_author_link.library_id=author_library_link.library_id
					)
					";

				run_query($query, "author_library_link without an library_author_link", 2);

				$query="
					SELECT *
					FROM author_tool_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM tool_author_link
						WHERE tool_author_link.author_id=author_tool_link.author_id
						AND tool_author_link.tool_id=author_tool_link.tool_id
					)
					";

				run_query($query, "author_tool_link without an tool_author_link", 2);

				// Custom validation for e-mail image cache

				$query="
					SELECT email
					FROM author_email
					";

				$result = mysqli_query($mysqli, $query) or die ('Could not run query: ' . mysqli_error($mysqli));

				echo INDENT . '<p><b>' . 'missing cache images' . '</b></p>' . LF . LF;

				$missing = 0;

				if (mysqli_num_rows($result) != 0)
				{
					$class = 'odd';

					while ($row = mysqli_fetch_assoc($result))
					{
						$image = text_image($row ['email']);

						if (!is_readable($image))
						{
							if ($missing == 0)
							{
								echo INDENT . '<table class="details">' . LF;
							}

							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;

							echo INDENT . TAB . TAB . '<td>' . $row ['email'] . '</td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . $image . '</td>' . LF;

							echo INDENT . TAB . '</tr>' . LF;

							$class = ($class == 'even') ? 'odd' : 'even';

							$missing++;
						}
					}
				}

				if ($missing > 0)
				{
					echo INDENT . '</table>' . LF . LF;
				}
				else
				{
					echo INDENT . '<p>None</p>' . LF . LF;
				}

				mysqli_free_result($result);
			}

			elseif (isset($_GET ['type']) && $_GET ['type']=='emus')
			{
				$query="
					SELECT emulator_id, emulator_contents_id
					FROM emulator
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM emulator_contents_emulator_link
						WHERE emulator_contents_emulator_link.emulator_id=emulator.emulator_id
						AND emulator_contents_emulator_link.emulator_contents_id=emulator.emulator_contents_id
					)
					ORDER BY emulator_contents_id, emulator_id;
					";

				run_query($query, "Emulators missing from the appropriate contents page", 2);

				$query="
					SELECT *
					FROM emulator_author_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM author_emulator_link
						WHERE author_emulator_link.author_id=emulator_author_link.author_id
						AND author_emulator_link.emulator_id=emulator_author_link.emulator_id
						AND author_emulator_link.relationship=emulator_author_link.relationship
					)
					ORDER BY author_id, emulator_id;
					";

				run_query($query, "emulator_author_link without an author_emulator_link", 4);

				$query="
					SELECT *
					FROM emulator_library_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM library_emulator_link
						WHERE library_emulator_link.library_id=emulator_library_link.library_id
						AND library_emulator_link.emulator_id=emulator_library_link.emulator_id
					)
					ORDER BY library_id, emulator_id;
					";

				run_query($query, "emulator_library_link without an library_emulator_link", 2);

				$query="
					SELECT *
					FROM emulator_tool_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM tool_emulator_link
						WHERE tool_emulator_link.tool_id=emulator_tool_link.tool_id
						AND tool_emulator_link.emulator_id=emulator_tool_link.emulator_id
					)
					ORDER BY tool_id, emulator_id;
					";

				run_query($query, "emulator_tool_link without an tool_emulator_link", 2);

				$query="
					SELECT *
					FROM emulator_relative_link erl1
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM emulator_relative_link erl2
						WHERE erl2.relative_id=erl1.emulator_id
						AND erl2.emulator_id=erl1.relative_id
					)
					ORDER BY relative_id, emulator_id;
					";

				run_query($query, "emulator_relative_link without return link", 3);

				$query="
					SELECT concat('emus/', emulator.emulator_contents_id, '/', emulator.emulator_id), emulator_file.name
					FROM emulator_file, emulator
					WHERE emulator.emulator_id=emulator_file.emulator_id
					AND NOT EXISTS
					(
						SELECT 1
						FROM zip
						WHERE zip.path=concat('emus/', emulator.emulator_contents_id, '/', emulator.emulator_id)
						AND zip.name=emulator_file.name
					)
					ORDER BY emulator_file.name, concat('emus/', emulator.emulator_contents_id, '/', emulator.emulator_id);
					";

				run_query($query, "emulator_file without a zip", 2);

				$query="
					SELECT *
					FROM emulator_contents_emulator_link
					WHERE emulator_contents_id NOT IN ('enhanced', 'nonmame', 'recent', 'recommended', 'screensavers')
					AND NOT EXISTS
					(
						SELECT 1
						FROM emulator
						WHERE emulator.emulator_id=emulator_contents_emulator_link.emulator_id
						AND emulator.emulator_contents_id=emulator_contents_emulator_link.emulator_contents_id
					);
					";

				run_query($query, "emulator_contents_emulator_link with invalid emulator", 2);

				/*$query="
					SELECT emulator.emulator_id, emulator_file.name, CEIL(zip.bytes/1024), emulator_file.size
					FROM emulator_file, emulator, zip
					WHERE emulator_file.emulator_id=emulator.emulator_id
					AND zip.path=concat('emus/', emulator.emulator_contents_id, '/', emulator.emulator_id)
					AND zip.name=emulator_file.name
					AND CEIL(zip.bytes/1024)!=emulator_file.size;
					";

				run_query($query, "emulator_file with incorrect size", 4);*/

				$query="
					SELECT emulator_id, dat
					FROM emulator
					WHERE dat NOT IN ('dummy', 'empty')
					AND NOT EXISTS
					(
						SELECT 1
						FROM game
						WHERE emulator.dat=game.dat
					)
					ORDER BY dat;
					";

				run_query($query, "Emulators referring to a missing dat", 2);
			}

			elseif (isset($_GET ['type']) && $_GET ['type']=='files')
			{
				$query="
					SELECT path, name
					FROM snap
					WHERE path LIKE '%/%/%'
					AND NOT EXISTS
					(
						SELECT 1
						FROM emulator, game
						WHERE emulator.dat=game.dat
						AND snap.path=concat('emus/', emulator.emulator_contents_id, '/', emulator.emulator_id)
						AND snap.name LIKE concat(game.game_name, '_%.png')
					)
					AND NOT EXISTS
					(
						SELECT 1
						FROM emulator, game
						WHERE emulator.dat=game.dat
						AND snap.path=concat('emus/', emulator.emulator_contents_id, '/', emulator.emulator_id)
						AND snap.name LIKE concat(game.game_name, '_%.jpg')
					)
					ORDER BY path, name;
					";

				//run_query($query, "snap without a game", 2);

				$query="
					SELECT path, name
					FROM snap
					WHERE path LIKE '%/%'
					AND path NOT LIKE '%/%/%'
					AND NOT EXISTS
					(
						SELECT 1
						FROM emulator
						WHERE snap.path=concat('emus/', emulator.emulator_contents_id)
						AND snap.name LIKE concat(emulator.emulator_id, '_%.png')
					)
					AND NOT EXISTS
					(
						SELECT 1
						FROM emulator
						WHERE snap.path=concat('emus/', emulator.emulator_contents_id)
						AND snap.name LIKE concat(emulator.emulator_id, '_%.jpg')
					)
					ORDER BY path, name;
					";

				run_query($query, "snap without an emulator", 2);

				$query="
					SELECT path, name
					FROM image
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM game
						WHERE (dat like 'MAME%' or dat='nonmame')
						AND image.name=concat(game.game_name, '.png')
					)
					ORDER BY path, name;
					";

				run_query($query, "image without a game", 2);

				$query="
					SELECT path, name
					FROM zip
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM emulator_file, emulator
						WHERE emulator_file.emulator_id=emulator.emulator_id
						AND zip.path=concat('emus/', emulator.emulator_contents_id, '/', emulator.emulator_id)
						AND zip.name=emulator_file.name
					)
					AND NOT EXISTS
					(
						SELECT 1
						FROM library_file, library
						WHERE library_file.library_id=library.library_id
						AND zip.path=concat('libs/', library.library_contents_id, '/', library.library_id)
						AND zip.name=library_file.name
					)
					AND NOT EXISTS
					(
						SELECT 1
						FROM tool_file, tool
						WHERE tool_file.tool_id=tool.tool_id
						AND zip.path=concat('tools/', tool.tool_contents_id, '/', tool.tool_id)
						AND zip.name=tool_file.name
					)
					ORDER BY path, name;
					";

				run_query($query, "zip without an emulator_file, library_file or tool_file", 2);
			}

			elseif (isset($_GET ['type']) && $_GET ['type']=='games')
			{
				$query="
					SELECT distinct dat
					FROM game
					WHERE dat NOT IN ('nonmame')
					AND NOT EXISTS
					(
						SELECT 1
						FROM emulator
						WHERE emulator.dat=game.dat
					)
					ORDER BY dat;
					";

				run_query($query, "Unused dats", 1);
			}

			elseif (isset($_GET ['type']) && $_GET ['type']=='libs')
			{
				$query="
					SELECT library_id, library_contents_id
					FROM library
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM library_contents_library_link
						WHERE library_contents_library_link.library_id=library.library_id
						AND library_contents_library_link.library_contents_id=library.library_contents_id
					)
					ORDER BY library_contents_id, library_id;
					";

				run_query($query, "library without a library_contents_library_link", 2);

				$query="
					SELECT *
					FROM library_author_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM author_library_link
						WHERE author_library_link.author_id=library_author_link.author_id
						AND author_library_link.library_id=library_author_link.library_id
					)
					ORDER BY author_id, library_id;
					";

				run_query($query, "library_author_link without an author_library_link", 2);

				$query="
					SELECT *
					FROM library_emulator_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM emulator_library_link
						WHERE emulator_library_link.library_id=library_emulator_link.library_id
						AND emulator_library_link.emulator_id=library_emulator_link.emulator_id
					)
					ORDER BY emulator_id, library_id;
					";

				run_query($query, "library_emulator_link without an emulator_library_link", 2);

				$query="
					SELECT concat('libs/', library.library_contents_id, '/', library.library_id), library_file.name
					FROM library_file, library
					WHERE library.library_id=library_file.library_id
					AND NOT EXISTS
					(
						SELECT 1
						FROM zip
						WHERE zip.path=concat('libs/', library.library_contents_id, '/', library.library_id)
						AND zip.name=library_file.name
					)
					ORDER BY library_file.name, concat('libs/', library.library_contents_id, '/', library.library_id);
					";

				run_query($query, "library_file without a zip", 2);

				$query="
					SELECT *
					FROM library_relative_link lrl1
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM library_relative_link lrl2
						WHERE lrl2.relative_id=lrl1.library_id
						AND lrl2.library_id=lrl1.relative_id
					)
					ORDER BY relative_id, library_id;
					";

				run_query($query, "library_relative_link without reverse link", 3);

				$query="
					SELECT *
					FROM library_contents_library_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM library
						WHERE library.library_id=library_contents_library_link.library_id
						AND library.library_contents_id=library_contents_library_link.library_contents_id
					);
				";

				run_query($query, "library_contents_library_link with invalid library", 2);

				/*$query="
					SELECT library.library_id, library_file.name, CEIL(zip.bytes/1024), library_file.size
					FROM library_file, library, zip
					WHERE library_file.library_id=library.library_id
					AND zip.path=concat('emus/', library.library_contents_id, '/', library.library_id)
					AND zip.name=library_file.name
					AND CEIL(zip.bytes/1024)!=library_file.size;
					";

				run_query($query, "library_file with incorrect size", 4);*/
			}

			elseif (isset($_GET ['type']) && $_GET ['type']=='tools')
			{
				$query="
					SELECT tool_id, tool_contents_id
					FROM tool
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM tool_contents_tool_link
						WHERE tool_contents_tool_link.tool_id=tool.tool_id
						AND tool_contents_tool_link.tool_contents_id=tool.tool_contents_id
					)
					ORDER BY tool_contents_id, tool_id;
					";

				run_query($query, "tool without a tool_contents_tool_link", 2);

				$query="
					SELECT *
					FROM tool_author_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM author_tool_link
						WHERE author_tool_link.author_id=tool_author_link.author_id
						AND author_tool_link.tool_id=tool_author_link.tool_id
					)
					ORDER BY author_id, tool_id;
					";

				run_query($query, "tool_author_link without an author_tool_link", 2);

				$query="
					SELECT *
					FROM tool_emulator_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM emulator_tool_link
						WHERE emulator_tool_link.tool_id=tool_emulator_link.tool_id
						AND emulator_tool_link.emulator_id=tool_emulator_link.emulator_id
					)
					ORDER BY emulator_id, tool_id;
					";

				run_query($query, "tool_emulator_link without an emulator_tool_link", 2);

				$query="
					SELECT concat('tools/', tool.tool_contents_id, '/', tool.tool_id), tool_file.name
					FROM tool_file, tool
					WHERE tool.tool_id=tool_file.tool_id
					AND NOT EXISTS
					(
						SELECT 1
						FROM zip
						WHERE zip.path=concat('tools/', tool.tool_contents_id, '/', tool.tool_id)
						AND zip.name=tool_file.name
					)
					ORDER BY tool_file.name, concat('tools/', tool.tool_contents_id, '/', tool.tool_id);
					";

				run_query($query, "tool_file without a zip", 2);

				$query="
					SELECT *
					FROM tool_contents_tool_link
					WHERE NOT EXISTS
					(
						SELECT 1
						FROM tool
						WHERE tool.tool_id=tool_contents_tool_link.tool_id
						AND tool.tool_contents_id=tool_contents_tool_link.tool_contents_id
					);
					";

				run_query($query, "tool_contents_tool_link with invalid tool", 2);

				/*$query="
					SELECT tool.tool_id, tool_file.name, CEIL(zip.bytes/1024), tool_file.size
					FROM tool_file, tool, zip
					WHERE tool_file.tool_id=tool.tool_id
					AND zip.path=concat('emus/', tool.tool_contents_id, '/', tool.tool_id)
					AND zip.name=tool_file.name
					AND CEIL(zip.bytes/1024)!=tool_file.size;
					";

				run_query($query, "tool_file with incorrect size", 4);*/
			}

			// Standard page footer (XHTML compliance logo)

			include '../resources/bottom.php';
		?>
	</body>
</html>
