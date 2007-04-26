<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('resources/include.php');

			// Display the page title

			echo '<title>CAESAR</title>' . LF . LF;

			// Include standard <head> metadata

			include('resources/head.php');
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the news)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			$non_xhtml_compliant="yes";

			include('resources/top.php');

			// Display the news

			echo INDENT . 'Have some news to tell us about? Then <a href="http://www.logiqx.com/forum/viewforum.php?f=15">submit news</a> here!' . LF ;

			if (isset($_GET['year']) && isset($_GET['month']))
			{
				$news='news/' . 'arc' . $_GET['month'] . '-' . $_GET['year'] . '.txt';

				if (file_exists($news))
					include($news);
			}
			else if (isset($_GET['year']))
			{
				for ($i=11; $i>=0; $i--)
				{
					$news='news/' . 'arc' . $i . '-' . $_GET['year'] . '.txt';

					if (file_exists($news))
						include($news);
				}
			}
			else
			{
				$news='news/news.txt';

				if (file_exists($news))
					include($news);
			}

			// Standard page footer (counter)

			include('resources/bottom.php');
		?>
	</body>
</html>
