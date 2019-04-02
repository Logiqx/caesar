<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include '../resources/include.php';

			// Display the page title

			echo '<title>CAESAR - Past News</title>' . LF . LF;

			// Include standard <head> metadata

			include '../resources/head.php';
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the news)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			include '../resources/top.php';

			for ($i=date("Y"); $i>=2000; $i--)
			{
				$yearOutput = false;
				$class = 'odd';

				for ($j=11; $j>=0; $j--)
				{
					if (file_exists('../news/arc' . $j . '-' . $i . '.txt'))
					{
						if ($yearOutput == false)
						{
							echo INDENT . '<table class="links">' . LF;
							echo INDENT . TAB . '<tr><th>' . $i . '</th></tr>' . LF;
							$yearOutput = true;
						}

						echo INDENT . TAB . '<tr class="' . $class . '"><td><a href="../news.php?year=' . $i . '&amp;month=' . $j . '">' . date('F', mktime(0, 0, 0, $j+1, 1)) . ' ' . $i . '</a></td></tr>' . LF;

						$class = ($class == 'even') ? 'odd' : 'even';
					}
				}

				if ($yearOutput == true)
				{
					echo INDENT . '</table>' . LF . LF;
					echo INDENT . '<p/>' . LF . LF;
				}
			}

			// Standard page footer (counter)

			include '../resources/bottom.php';
		?>
	</body>
</html>

