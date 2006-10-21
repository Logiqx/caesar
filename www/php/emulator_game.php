<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Get emulator details

			$query = 'SELECT *
				FROM	emulator
				WHERE	emulator_id=' . "'" . $_GET ['id'] . "'";

			$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

			if (mysql_num_rows ($result) != 0)
			{
				$emulator = mysql_fetch_assoc ($result);
			}

			mysql_free_result ($result);

			// Display the page title

			if (isset($emulator))
			{
				$query = 'SELECT *
					FROM	game
					WHERE	dat=' . "'" . $emulator['dat'] . "'
					AND	game_name='" . $_GET ['game'] ."'";

				$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				if (mysql_num_rows ($result) != 0)
				{
					$row = mysql_fetch_assoc ($result);

					echo '<title>CAESAR - ' . htmlspecialchars($row ['description']) . '</title>' . LF . LF;
				}
				else
				{
					echo '<title>CAESAR</title>' . LF . LF;
				}

				mysql_free_result ($result);
			}
			else
			{
				echo '<title>CAESAR</title>' . LF . LF;
			}

			// Include standard <head> metadata

			include ('../resources/head.php');
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the information)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			include ('../resources/top.php');

			if (isset($emulator))
			{
				// Select the page title and comment

				$query = 'SELECT *
					FROM	game
					WHERE	dat=' . "'" . $emulator['dat'] . "'
					AND	game_name='" . $_GET ['game'] ."'";

				$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				// If no rows were found, the id was invalid (or unspecified)

				if (mysql_num_rows ($result) != 0)
				{
					// Title and comment

					$row = mysql_fetch_assoc ($result);

					mysql_free_result ($result);

					echo INDENT . '<h2>' . htmlspecialchars($row ['description']) . '</h2>' . LF . LF;

					// Create table for the links and define the column groups

					echo INDENT . '<table class="details">' . LF;

					echo INDENT . TAB . '<colgroup class="heading"/>' . LF;
					echo INDENT . TAB . '<colgroup class="details"/>' . LF;

					$class = 'odd';

					// Group

					$query = "SELECT *
						FROM	game
						WHERE	x_master_ind=1
						AND	x_group_name='" . $row ['x_group_name'] . "'";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						$group = mysql_fetch_assoc ($result);

						mysql_free_result ($result);
					}

					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>Group</th>' . LF;
					echo INDENT . TAB . TAB . '<td><a href="game_group.php?id=' . $row ['x_group_name'] . '#' . $row ['x_map_name'] . '">' . htmlspecialchars($group ['description']) . '</a></td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';

					// Manufacturer

					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>Manufacturer</th>' . LF;
					echo INDENT . TAB . TAB . '<td>' . htmlspecialchars($row ['manufacturer']) . '</td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';

					// Year

					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>Year</th>' . LF;
					echo INDENT . TAB . TAB . '<td>' . $row ['year'] . '</td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';

					// Size

					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>Size</th>' . LF;
					echo INDENT . TAB . TAB . '<td>' . ceil($row ['x_size'] / 1024) . 'KB</td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';

					// Board

					if ($row ['board'] != "")
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
						echo INDENT . TAB . TAB . '<th>Board</th>' . LF;
						echo INDENT . TAB . TAB . '<td>' . $row ['board'] . '</td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					// Category

					$query = 'SELECT *
						FROM catver
						WHERE game_name=' . "'" . $row ['x_map_name'] . "'";

					$catver = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($catver) != 0)
					{
						$catver_row = mysql_fetch_assoc ($catver);

						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
						echo INDENT . TAB . TAB . '<th>Category</th>' . LF;
						echo INDENT . TAB . TAB . '<td>' . $catver_row ['category'] . '</td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;
					}

					mysql_free_result ($catver);

					// In MAME?

					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>In MAME?</th>' . LF;
					echo INDENT . TAB . TAB . '<td>' . ($row ['x_nonmame_ind']==1 ? 'No' : 'Yes') . '</td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';

					// Emulator

					echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
					echo INDENT . TAB . TAB . '<th>Emulator</th>' . LF;
					echo INDENT . TAB . TAB . '<td><a href="emulator.php?id=' . $emulator ['emulator_id'] . '">' . $emulator ['name'] . '</a></td>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = ($class == 'even') ? 'odd' : 'even';

					// Check for history

					$additional_info=0;

					$query = 'SELECT history_id
						FROM history_link
						WHERE history_link.game_name=' . "'" . $row ['x_map_name'] . "'";

					$history = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($history) != 0)
					{
						if ($additional_info == 0)
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<th>Additional Information</th>' . LF;
							echo INDENT . TAB . TAB . '<td>' . LF;

							$additional_info++;
						}

						echo INDENT . TAB . TAB . TAB . '<a href="history.php?id=' . $row ['x_map_name'] . '">History</a><br />' . LF;
					}

					mysql_free_result ($history);

					// Check for mameinfo (game)

					$query = 'SELECT mameinfo_id
						FROM mameinfo_link
						WHERE mameinfo_link.game_name=' . "'" . $row ['x_group_name'] . "'";

					$mameinfo = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if ($emulator ['emulator_id']=="mame" && mysql_num_rows ($mameinfo) != 0)
					{
						if ($additional_info == 0)
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<th>Additional Information</th>' . LF;
							echo INDENT . TAB . TAB . '<td>' . LF;

							$additional_info++;
						}

						echo INDENT . TAB . TAB . TAB . '<a href="mameinfo.php?id=' . $row ['x_group_name'] . '">MAMEInfo (game)</a><br />' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					mysql_free_result ($mameinfo);

					// Check for mameinfo (driver)

					$query = 'SELECT mameinfo_id
						FROM mameinfo_link
						WHERE mameinfo_link.game_name=' . "'" . $row ['game_sourcefile'] . "'";

					$mameinfo = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if ($_GET ['id']=="mame" && mysql_num_rows ($mameinfo) != 0)
					{
						if ($additional_info == 0)
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<th>Additional Information</th>' . LF;
							echo INDENT . TAB . TAB . '<td>' . LF;

							$additional_info++;
						}

						echo INDENT . TAB . TAB . TAB . '<a href="mameinfo.php?id=' . $row ['game_sourcefile'] . '">MAMEInfo (driver)</a><br />' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					mysql_free_result ($mameinfo);

					// MAWS

					if ($emulator ['emulator_id']=="mame")
					{
						if ($additional_info == 0)
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<th>Additional Information</th>' . LF;
							echo INDENT . TAB . TAB . '<td>' . LF;

							$additional_info++;
						}

						echo INDENT . TAB . TAB . TAB . '<a href="http://www.mameworld.net/maws/romset/' . $row ['x_map_name'] . '">MAWS</a><br />' . LF;
					}

					// Round off additional information

					if ($additional_info == 0)
					{
						echo INDENT . TAB . TAB . '</td>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					// End of table

					echo INDENT . '</table>' . LF;

					// Master

					$query = "SELECT *
						FROM	game
						WHERE	x_master_ind=1
						AND	game_name='" . $row ['x_map_name'] ."'";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						$master = mysql_fetch_assoc ($result);
					}

					mysql_free_result ($result);

					// Get video details (for aspect ratio fixing)

					$query = "SELECT *
						FROM	game_video
						WHERE	dat='" . $master['dat'] . "'
						AND	game_name='" . $row ['x_map_name'] ."'";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					$orientation = 'horizontal';
					$x = 0;
					$y = 0;
					$aspectx = isset($emulator ['aspectx']) ? $emulator ['aspectx'] : 0;
					$aspecty = isset($emulator ['aspecty']) ? $emulator ['aspecty'] : 0;

					if (mysql_num_rows ($result) != 0)
					{
						while ($video = mysql_fetch_assoc ($result))
						{
							if (isset($video ['orientation']))
								$orientation = $video ['orientation'];

							if (isset($video ['width']))
								$x = $video ['width'];

							if (isset($video ['height']))
								$y = $video ['height'];

							if ($aspectx==0 && isset($video ['aspectx']))
								$aspectx = $video ['aspectx'];

							if ($aspecty==0 && isset($video ['aspecty']))
								$aspecty = $video ['aspecty'];
						}
					}

					mysql_free_result ($result);

					// Get display details (for aspect ratio fixing)

					$query = "SELECT max(x_orientation) orientation,
							max(x_rotated_width) as max_width, sum(x_rotated_width) as sum_width,
							max(x_rotated_height) as max_height, sum(x_rotated_height) as sum_height,
							max(x_aspectx) as max_aspectx, sum(x_aspectx) as sum_aspectx,
							max(x_aspecty) as max_aspecty, sum(x_aspecty) as sum_aspecty,
							count(*) as num_displays
						FROM	game_display
						WHERE	dat='" . $master['dat'] . "'
						AND	game_name='" . $row ['x_map_name'] ."'";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					$max_width = 0;
					$sum_width = 0;
					$max_height = 0;
					$sum_height = 0;
					$max_aspectx = isset($emulator ['aspectx']) ? $emulator ['aspectx'] : 0;
					$sum_aspectx = isset($emulator ['aspectx']) ? $emulator ['aspectx'] : 0;
					$max_aspecty = isset($emulator ['aspecty']) ? $emulator ['aspecty'] : 0;
					$sum_aspecty = isset($emulator ['aspecty']) ? $emulator ['aspecty'] : 0;
					$num_displays = 0;

					if (mysql_num_rows ($result) != 0)
					{
						while ($display = mysql_fetch_assoc ($result))
						{
							if (isset($display ['orientation']))
								$orientation = $display ['orientation'];

							if (isset($display ['max_width']))
								$max_width = $display ['max_width'];

							if (isset($display ['sum_width']))
								$sum_width = $display ['sum_width'];

							if (isset($display ['max_height']))
								$max_height = $display ['max_height'];

							if (isset($display ['sum_height']))
								$sum_height = $display ['sum_height'];

							if ($aspectx==0 && isset($display ['max_aspectx']))
								$max_aspectx = $display ['max_aspectx'];

							if ($aspectx==0 && isset($display ['sum_aspectx']))
								$sum_aspectx = $display ['sum_aspectx'];

							if ($aspecty==0 && isset($display ['max_aspecty']))
								$max_aspecty = $display ['max_aspecty'];

							if ($aspecty==0 && isset($display ['sum_aspecty']))
								$sum_aspecty = $display ['sum_aspecty'];

							if (isset($display ['num_displays']))
								$num_displays = $display ['num_displays'];
						}

						/* --- If width and height were not specified, set reasonable defaults! --- */

						if ($max_width==0 || $max_height==0)
						{
							if ($orientation=='horizontal')
							{
								$sum_width=$max_width=640;
								$sum_height=$max_height=480;
							}
							else
							{
								$sum_width=$max_width=480;
								$sum_height=$max_height=640;
							}
						}
					}

					mysql_free_result ($result);

					// Snaps

					$query = "SELECT *
						FROM	snap
						WHERE	path='emus/" . $emulator ['emulator_contents_id'] . "/" . $emulator ['emulator_id'] . "' and
							name like '" . $_GET ['game'] . "_%' and
							LEFT(name, " . (strlen($_GET ['game']) + 1) . ") = '" . $_GET ['game'] . "_' and
							LENGTH(name)>=" . (strlen($_GET ['game']) + 6) . " and
							LENGTH(name)<=" . (strlen($_GET ['game']) + 7) . "
						ORDER BY name";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						echo INDENT . '<h2>Snapshots</h2>' . LF . LF;
						echo INDENT . '<p>' . LF . LF;

						while ($snap = mysql_fetch_assoc ($result))
						{
							$width=$snap ['width'];
							$height=$snap ['height'];

							if ($num_displays > 0)
							{
								/* --- Guess at the layout of multi-screens! --- */

								$snap_aspect = 100 * $width / $height;

								$basic_aspect = 100 * $max_width / $max_height;
								$basic_error = abs($snap_aspect - $basic_aspect);

								$wide_aspect = 100 * $sum_width / $max_height;
								$wide_error = abs($snap_aspect - $wide_aspect);

								$tall_aspect = 100 * $max_width / $sum_height;
								$tall_error = abs($snap_aspect - $tall_aspect);

								$sourcefile = isset($row ['game_sourcefile']) ? $row ['game_sourcefile'] : '';

								if ($sourcefile == 'nbmj8688.c')
								{
									$aspectx = 85;    // 896;
									$aspecty = 100;   // 1056;
								}
								else if ($wide_error <= $tall_error && $wide_error <= $basic_error)
								{
									$aspectx = $sum_aspectx;
									$aspecty = $max_aspecty;
								}
								else if ($tall_error <= $basic_error && $sourcefile != 'cyberbal.c')
								{
									$aspectx = $max_aspectx;
									$aspecty = $sum_aspecty;
								}
								else
								{
									$aspectx = $max_aspectx;
									$aspecty = $max_aspecty;
								}
							}
							else
							{
								/* --- If aspect ratio is unknown, make a simple guess! --- */

								if ($aspectx==0 || $aspecty==0)
								{
									if ($width>=$height)
									{
										$aspectx=4;
										$aspecty=3;
									}
									else
									{
										$aspectx=3;
										$aspecty=4;
									}
								}

								/* --- Cropping should only occur for multi-screen games (i.e. not 4:3 or 3:4) --- */

								if (!(($aspectx==4 && $aspecty==3) || ($aspectx==3 && $aspecty==4)))
								{
									/* --- If image is cropped horizontally then fix aspectx --- */
	
									if ($width>=$x/2-16 && $width<=$x/2+16 && $height==$y)
									{
										//printf("Cropped horizontally %s\n", ext_file->name);
										$aspectx/=2;
									}

									/* --- If image is cropped vertically then fix aspecty --- */

									if ($width==$x && $height>=$y/2-16 && $height<=$y/2+16)
									{
										//printf("Cropped vertically %s\n", ext_file->name);
										$aspecty/=2;
									}
								}
							}

							/* --- Figure out the maximum acceptable dimensions for the snapshot --- */

							$limit_constant = 384;

							if ($aspectx > $aspecty)
							{
								// Works for all wide displays (x:y horizontal or x:y multi-screen)
								$limit_width = $limit_constant * $aspectx / $aspecty;
								$limit_height = $limit_constant;
							}
							else
							{
								// Works for all tall displays (x:y vertical or x:y multi-screen)
								$limit_width = $limit_constant;
								$limit_height = $limit_constant * $aspecty / $aspectx;

							}

							//print 'limit=' . $limit_width . 'x' . $limit_height . '<br/>';

							/* --- Resize the image to match the aspect ratio and acceptable dimensions --- */

							//print 'before=' . round($width) . 'x' . round($height) . '<br/>';

							$reduced = 0;

							if ($width*$aspecty<$height*$aspectx)
							{
								/* --- Too narrow --- */

								while ($width*$aspecty<$height*$aspectx)
								{
									if ($height*$aspectx/$aspecty <= $limit_width)
									{
										$width=$height*$aspectx/$aspecty;
									}
									else if ($width*$aspecty/$aspectx <= $limit_height)
									{
										$height=$width*$aspecty/$aspectx;
									}
									else
									{
										$width /= 2;
										$height /= 2;
										$reduced++;
									}
								}
							}

							else if ($width*$aspecty>$height*$aspectx)
							{
								/* --- Too wide --- */

								while ($width*$aspecty>$height*$aspectx)
								{
									if ($width*$aspecty/$aspectx <= $limit_height)
									{
										$height=$width*$aspecty/$aspectx;
									}
									else if ($height*$aspectx/$aspecty <= $limit_width)
									{
										$width=$height*$aspectx/$aspecty;
									}
									else
									{
										$width /= 2;
										$height /= 2;
										$reduced++;
									}
								}
							}

							else
							{
								/* --- Correct aspect ratio but may be too big --- */

								while ($width>$limit_width || $height>$limit_height)
								{
									$width /= 2;
									$height /= 2;
									$reduced++;
								}
							}

							//print 'after=' . round($width) . 'x' . round($height) . '<br/>';

							/* --- The image can finally be displayed (skip dummy pixel snaps)! --- */

							if ($width > 1 && $height > 1)
							{
								echo INDENT . TAB . '<img src="../snaps/' . $snap ['path'] . '/' .
									$snap ['name'] . '" alt="' . $snap ['name'] .
									' (' . $aspectx . ':' . $aspecty . ')' .
									($reduced ? ' [halved in size]' : '') .
									'" width="' . round($width) .
									'" height="' . round($height) . '"/>' . LF;
							}
						}

						echo INDENT . '</p>' . LF;
					}

					mysql_free_result ($result);

					// Details

					if ($row ['x_nonmame_ind'] == 1)
						echo INDENT . '<h2>Game Details</h2>' . LF . LF;
					else
						echo INDENT . '<h2>Game Details (according to MAME)</h2>' . LF . LF;

					// Chips

					$query = "SELECT *
						FROM	game_chip
						WHERE	dat='" . $master['dat'] . "'
						AND	game_name='" . $row ['x_map_name'] ."'
						ORDER 	BY type DESC, chip_name";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="general"/>' . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Chips</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($chip = mysql_fetch_assoc ($result))
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<td>' . $chip ['type'];
							echo ': ' . $chip ['chip_name'];
							if (isset($chip ['clock']))
								echo ', ' . $chip ['clock']/1000000 . 'MHz';
							echo '</td>' . LF;
							echo INDENT . TAB . '</tr>' . LF;

							$class = ($class == 'even') ? 'odd' : 'even';
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($result);

					// Video

					$query = "SELECT *
						FROM	game_video
						WHERE	dat='" . $master['dat'] . "'
						AND	game_name='" . $row ['x_map_name'] ."'";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="general"/>' . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Video</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($video = mysql_fetch_assoc ($result))
						{
							if (isset($video ['screen']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Screen: ' . $video ['screen'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($video ['orientation']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Orientation: ' . $video ['orientation'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($video ['width']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Resolution: ' . $video ['width'] . ' x ' . $video ['height'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($video ['refresh']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Refresh: ' . $video ['refresh'] . 'Hz</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($result);

					// Display

					$query = "SELECT *
						FROM	game_display
						WHERE	dat='" . $master['dat'] . "'
						AND	game_name='" . $row ['x_map_name'] ."'";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						$display_no = 1;

						while ($display = mysql_fetch_assoc ($result))
						{
							echo INDENT . '<table class="links">' . LF;
							echo INDENT . TAB . '<colgroup class="general"/>' . LF;

							echo INDENT . TAB . '<tr>' . LF;
							if (mysql_num_rows ($result) == 1)
								echo INDENT . TAB . TAB . '<th>Display</th>' . LF;
							else
								echo INDENT . TAB . TAB . '<th>Display '. $display_no . '</th>' . LF;
							echo INDENT . TAB . '</tr>' . LF;

							$class = 'odd';

							if (isset($display ['type']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Type: ' . $display ['type'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($display ['x_orientation']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Orientation: ' . $display ['x_orientation'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($display ['x_rotated_width']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Resolution: ' . $display ['x_rotated_width'] . ' x ' . $display ['x_rotated_height'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($display ['refresh']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Refresh: ' . $display ['refresh'] . 'Hz</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							$display_no++;
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($result);

					// Sound

					$query = "SELECT *
						FROM	game_sound
						WHERE	dat='" . $master['dat'] . "'
						AND	game_name='" . $row ['x_map_name'] ."'";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="general"/>' . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Sound</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($video = mysql_fetch_assoc ($result))
						{
							if (isset($video ['channels']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Channels: ' . $video ['channels'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($result);

					// Input

					$query = "SELECT *
						FROM	game_input
						WHERE	dat='" . $master['dat'] . "'
						AND	game_name='" . $row ['x_map_name'] ."'";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="general"/>' . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Input</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($input = mysql_fetch_assoc ($result))
						{
							if (isset($input ['players']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Players: ' . $input ['players'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($input ['control']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Control: ' . $input ['control'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($input ['buttons']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Buttons: ' . $input ['buttons'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($input ['coins']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Coins: ' . $input ['coins'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($input ['service']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Service: ' . $input ['service'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($input ['tilt']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Tilt: ' . $input ['tilt'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($result);

					// Control

					$query = "SELECT *
						FROM	game_control
						WHERE	dat='" . $master['dat'] . "'
						AND	game_name='" . $row ['x_map_name'] ."'";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="general"/>' . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Controls</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($control = mysql_fetch_assoc ($result))
						{
							if (isset($control ['type']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Type: ' . $control ['type'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($result);

					// Driver

					$query = 'SELECT *
						FROM	game_driver
						WHERE	dat=' . "'" . $emulator['dat'] . "'
						AND	game_name='" . $_GET ['game'] ."'";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						echo INDENT . '<h2>Emulation Details</h2>' . LF . LF;

						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="general"/>' . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Driver</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($sound = mysql_fetch_assoc ($result))
						{
							if (isset($sound ['status']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Status: ' . $sound ['status'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($sound ['emulation']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Emulation: ' . $sound ['emulation'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($sound ['color']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Color: ' . $sound ['color'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($sound ['sound']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Sound: ' . $sound ['sound'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($sound ['graphic']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Graphic: ' . $sound ['graphic'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($sound ['cocktail']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Cocktail: ' . $sound ['cocktail'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($sound ['protection']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Protection: ' . $sound ['protection'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($sound ['palettesize']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Palette size: ' . $sound ['palettesize'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($sound ['colordeep']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Color Depth: ' . $sound ['colordeep'] . ' bits</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}

							if (isset($sound ['credits']))
							{
								echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
								echo INDENT . TAB . TAB . '<td>Credits: ' . $sound ['credits'] . '</td>' . LF;
								echo INDENT . TAB . '</tr>' . LF;

								$class = ($class == 'even') ? 'odd' : 'even';
							}
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($result);

					// ROMs

					$query = "SELECT *
						FROM	game_rom
						WHERE	dat='" . $emulator['dat'] . "'
						AND	game_name='" . $_GET ['game'] ."'
						ORDER 	BY region, rom_name";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						echo INDENT . '<h2>ROMs required by ' . $emulator ['name'] . '</h2>' . LF . LF;

						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="name"/>' . LF;
						echo INDENT . TAB . '<colgroup class="size"/>' . LF;
						echo INDENT . TAB . '<colgroup class="crc"/>' . LF;
						echo INDENT . TAB . '<colgroup class="sha1"/>' . LF;
						if ($emulator['emulator_id'] != 'mame')
						{
							echo INDENT . TAB . '<colgroup class="nonmame"/>' . LF;
							echo INDENT . TAB . '<colgroup class="rombuild"/>' . LF;
						}
						else
						{
							echo INDENT . TAB . '<colgroup class="region"/>' . LF;
						}

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Name</th>' . LF;
						echo INDENT . TAB . TAB . '<th>Size</th>' . LF;
						echo INDENT . TAB . TAB . '<th>CRC</th>' . LF;
						echo INDENT . TAB . TAB . '<th>SHA1</th>' . LF;
						if ($emulator['emulator_id'] != 'mame')
						{
							echo INDENT . TAB . TAB . '<th>In MAME?</th>' . LF;
							echo INDENT . TAB . TAB . '<th>In ROMBuild?</th>' . LF;
						}
						else
						{
							echo INDENT . TAB . TAB . '<th>Region</th>' . LF;
						}
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($rom = mysql_fetch_assoc ($result))
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<td>' . $rom ['rom_name'] . '</td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . $rom ['size'] . '</td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . (isset($rom ['crc']) ? $rom ['crc'] : '*** unknown ***') . (isset($rom ['status']) ? '<br/>(' . $rom ['status'] . ')' : '') . '</td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . (isset($rom ['sha1']) ? $rom ['sha1'] : '*** unknown ***') . (isset($rom ['status']) ? '<br/>(' . $rom ['status'] . ')' : '') . '</td>' . LF;
							if ($emulator['emulator_id'] != 'mame')
							{
								echo INDENT . TAB . TAB . '<td>' . ($rom ['x_mame_ind'] == 1 ? 'Yes' : '-') . '</td>' . LF;
								echo INDENT . TAB . TAB . '<td>' . ($rom ['x_rombuild_ind'] == 1 ? 'Yes' : '-') . '</td>' . LF;
							}
							else
							{
								echo INDENT . TAB . TAB . '<td>' . $rom ['region'] . '</td>' . LF;
							}
							echo INDENT . TAB . '</tr>' . LF;

							$class = ($class == 'even') ? 'odd' : 'even';
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($result);

					// Disks

					$query = "SELECT *
						FROM	game_disk
						WHERE	dat='" . $emulator['dat'] . "'
						AND	game_name='" . $_GET ['game'] ."'
						ORDER 	BY disk_name";

					$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

					if (mysql_num_rows ($result) != 0)
					{
						echo INDENT . '<h2>Disks required by ' . $emulator ['name'] . '</h2>' . LF . LF;

						echo INDENT . '<table class="links">' . LF;
						echo INDENT . TAB . '<colgroup class="name"/>' . LF;
						echo INDENT . TAB . '<colgroup class="sha1"/>' . LF;

						echo INDENT . TAB . '<tr>' . LF;
						echo INDENT . TAB . TAB . '<th>Name</th>' . LF;
						echo INDENT . TAB . TAB . '<th>SHA1</th>' . LF;
						echo INDENT . TAB . '</tr>' . LF;

						$class = 'odd';

						while ($disk = mysql_fetch_assoc ($result))
						{
							echo INDENT . TAB . '<tr class="'. $class . '">' . LF;
							echo INDENT . TAB . TAB . '<td>' . $disk ['disk_name'] . '</td>' . LF;
							echo INDENT . TAB . TAB . '<td>' . $disk ['sha1'] . '</td>' . LF;
							echo INDENT . TAB . '</tr>' . LF;

							$class = ($class == 'even') ? 'odd' : 'even';
						}

						echo INDENT . '</table>' . LF;
					}

					mysql_free_result ($result);
				}
				else
				{
					echo INDENT . 'Invalid id has been passed as a parameter, check the URL!' . LF;

					mysql_free_result ($result);
				}
			}
			else
			{
				echo INDENT . 'Invalid id has been passed as a parameter, check the URL!' . LF;
			}

			// Standard page footer (XHTML compliance logo)

			include ('../resources/bottom.php');
		?>
	</body>
</html>
