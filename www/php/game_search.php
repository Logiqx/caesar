<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Display the page title

			echo '<title>CAESAR - Game Search Results</title>' . LF . LF;

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

			if (isset($_GET['desc']))
				$desc=$_GET['desc'];
			else
				$desc='';

			if (isset($_GET['desc_match']))
				$desc_match=$_GET['desc_match'];
			else
				$desc_match='';

			if (isset($_GET['manu']))
				$manu=$_GET['manu'];
			else
				$manu='';

			if (isset($_GET['manu_match']))
				$manu_match=$_GET['manu_match'];
			else
				$manu_match='';

			if (isset($_GET['year']))
				$year=$_GET['year'];
			else
				$year='';

			if (isset($_GET['year_match']))
				$year_match=$_GET['year_match'];
			else
				$year_match='';

			if (isset($_GET['nonmame']))
				$nonmame=$_GET['nonmame'];
			else
				$nonmame='';

			if (isset($_GET['sourcefile']))
				$sourcefile=$_GET['sourcefile'];
			else
				$sourcefile='';

			if (isset($_GET['sort']))
				$sort=$_GET['sort'];
			else
				$sort='';

			// Display form

			echo INDENT . '<h2>Search Criteria</h2>' . LF . LF;

			echo INDENT . '<form action="game_search.php" method="get">' . LF;
			echo INDENT . TAB . '<table>' . LF;
			echo INDENT . TAB . TAB . '<tr>' . LF;
			echo INDENT . TAB . TAB . TAB . '<td align="center">' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="desc"><strong>Description</strong></label><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="desc" type="text" name="desc" value="' . $desc . '"/><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="desc_match_begins" ' . ($desc_match != 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="desc_match" value="begins"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="desc_match_begins">begins</label>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="desc_match_contains" ' . ($desc_match == 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="desc_match" value="contains"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="desc_match_contains">contains</label>' . LF;
			echo INDENT . TAB . TAB . TAB . '</td>' . LF;
			echo INDENT . TAB . TAB . TAB . '<td align="center">' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="manu"><strong>Manufacturer</strong></label><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="manu" type="text" name="manu" value="' . $manu . '"/><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="manu_match_begins" ' . ($manu_match != 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="manu_match" value="begins"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="manu_match_begins">begins</label>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="manu_match_contains" ' . ($manu_match == 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="manu_match" value="contains"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="manu_match_contains">contains</label>' . LF;
			echo INDENT . TAB . TAB . TAB . '</td>' . LF;
			echo INDENT . TAB . TAB . TAB . '<td align="center">' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="year"><strong>Year</strong></label><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="year" type="text" name="year" value="' . $year . '"/><br/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="year_match_begins" ' . ($year_match != 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="year_match" value="begins"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="year_match_begins">begins</label>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<input id="year_match_contains" ' . ($year_match == 'contains' ? 'checked="checked" ' : '') . 'type="radio" name="year_match" value="contains"/>' . LF;
			echo INDENT . TAB . TAB . TAB . TAB . '<label for="year_match_contains">contains</label>' . LF;
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

			$query = 'SELECT *
				FROM game
				WHERE x_master_ind=1
				AND x_hidden_ind IS NULL';

			if ($nonmame != '')
			{
				if ($args != '' )
					$args = $args . '&amp;';

				$args = $args . 'nonmame=' . $nonmame;

				$query = $query . " AND x_nonmame_ind=1";
			}

			if ($sourcefile != '')
			{
				if ($args != '' )
					$args = $args . '&amp;';

				$args = $args . 'sourcefile=' . $sourcefile;

				$query = $query . " AND game_sourcefile='" . $sourcefile . "'";
			}

			if ($desc != '')
			{
				if ($args != '' )
					$args = $args . '&amp;';

				$args = $args . 'desc=' . $desc;

				if ($desc_match != '')
					$args = $args . '&amp;desc_match=' . $desc_match;

				if ($desc_match == 'before')
					$query = $query . ' AND description < ' . "'" . strtoupper($desc) . "'";
				elseif ($desc_match == 'contains')
					$query = $query . ' AND description like ' . "'%" . strtoupper($desc) . "%'";
				else
					$query = $query . ' AND description like ' . "'" . strtoupper($desc) . "%'";
			}

			if ($manu != '')
			{
				if ($args != '' )
					$args = $args . '&amp;';

				$args = $args . 'manu=' . $manu;

				if ($manu_match != '')
					$args = $args . '&amp;manu_match=' . $manu_match;

				if ($manu_match == 'contains')
					$query = $query . ' AND manufacturer like ' . "'%" . strtoupper($manu) . "%'";
				else
					$query = $query . ' AND manufacturer like ' . "'" . strtoupper($manu) . "%'";
			}

			if ($year != '')
			{
				if ($args != '' )
					$args = $args . '&amp;';

				$args = $args . 'year=' . $year;

				if ($year_match != '')
					$args = $args . '&amp;year_match=' . $year_match;

				if ($year_match == 'contains')
					$query = $query . ' AND year like ' . "'%" . $year . "%'";
				else
					$query = $query . ' AND year like ' . "'" . $year . "%'";
			}

			if ($sort != '')
			{
				switch ($sort)
				{
					case 'desc':
						//echo INDENT . '<p>Sorted by Name</p>' . LF . LF;
						$query = $query . " ORDER BY description, year, manufacturer";
						break;
					case 'manu':
						//echo INDENT . '<p>Sorted by Manufacturer</p>' . LF . LF;
						$query = $query . " ORDER BY manufacturer, description, year";
						break;
					case 'year':
						//echo INDENT . '<p>Sorted by Year</p>' . LF . LF;
						$query = $query . " ORDER BY year, description, manufacturer";
						break;
				}
			}
			else
			{
				//echo INDENT . '<p>Sorted by Name</p>' . LF . LF;
				$query = $query . " ORDER BY description, year, manufacturer";
			}

			if ($desc != '' || $manu != '' || $year != '' || $nonmame != '' || $sourcefile != '')
			{
				$result = @mysql_query ($query) or die ('Could not run query: ' . mysql_error ());

				echo INDENT . '<hr/>' . LF . LF;

				echo INDENT . '<h2>Results</h2>' . LF . LF;

				echo INDENT . '<p>';

				switch (mysql_num_rows ($result))
				{
					case 0:
						echo 'No matches for the search criteria!';
						break;
					case 1:
						echo 'Exactly one match for the search criteria!';
						break;
					default:
						echo mysql_num_rows ($result) . ' matches for the search criteria!';
						break;
				}

				echo '</p>' . LF . LF;

				if (mysql_num_rows ($result) != 0)
				{
					echo INDENT . '<table class="links">' . LF;

					echo INDENT . TAB . '<colgroup class="name"/>' . LF;
					echo INDENT . TAB . '<colgroup class="manufacturer"/>' . LF;
					echo INDENT . TAB . '<colgroup class="year"/>' . LF;
					echo INDENT . TAB . '<colgroup class="nonmame"/>' . LF;

					echo INDENT . TAB . '<tr>' . LF;
					echo INDENT . TAB . TAB . '<th><a href="game_search.php?' . $args . '&amp;sort=desc">Name</a></th>' . LF;
					echo INDENT . TAB . TAB . '<th><a href="game_search.php?' . $args . '&amp;sort=manu">Manufacturer</a></th>' . LF;
					echo INDENT . TAB . TAB . '<th><a href="game_search.php?' . $args . '&amp;sort=year">Year</a></th>' . LF;
					echo INDENT . TAB . TAB . '<th>Non MAME?</th>' . LF;
					echo INDENT . TAB . '</tr>' . LF;

					$class = 'odd';

					while ($row = mysql_fetch_assoc ($result))
					{
						echo INDENT . TAB . '<tr class="'. $class . '">' . LF;

						echo INDENT . TAB . TAB . '<td><a href="game_group.php?id=';
						if ($row [ 'cloneof' ])
							echo $row [ 'cloneof' ];
						else
							echo $row [ 'game_name' ];
						echo '#' . $row [ 'game_name' ] . '">' . htmlspecialchars($row ['description']) . '</a></td>' . LF;
						echo INDENT . TAB . TAB . '<td>' . htmlspecialchars($row ['manufacturer']) . '</td>' . LF;

						echo INDENT . TAB . TAB . '<td>' . $row [ 'year' ] . '</td>' . LF;

						if ($row [ 'x_nonmame_ind' ] == 1)
							echo INDENT . TAB . TAB . '<td>Yes</td>' . LF;
						else
							echo INDENT . TAB . TAB . '<td>-</td>' . LF;

						echo INDENT . TAB . '</tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}

					echo INDENT . '</table>' . LF;
				}

				mysql_free_result ($result);
			}

			// Standard page footer (XHTML compliance logo)

			include ('../resources/bottom.php');
		?>
	</body>
</html>
