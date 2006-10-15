<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('resources/include.php');

			// Display the page title

			echo '<title>CAESAR - Error ' . $_GET['code'] . '</title>' . LF . LF;

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

			// Show the error

			switch ($_GET['code'])
			{
				case 400:
					echo INDENT . '<h1>Error 400 - Bad Request</h1>' . LF . LF;
					echo INDENT . '<p>Syntax error in the client request!</p>' . LF;
					break;
				case 401:
					echo INDENT . '<h2>Error 401 - Authorization Required</h2>' . LF . LF;
					echo INDENT . '<p>You are not authorized to access this section of the website!</p>' . LF;
					break;
				case 403:
					echo INDENT . '<h2>Error 403 - Forbidden</h2>' . LF . LF;
					echo INDENT . '<p>Directory browsing id forbidden on this server!</p>' . LF;
					break;
				case 404:
					echo INDENT . '<h2>Error 404 - Not Found</h2>' . LF . LF;
					echo INDENT . '<p>The page that you have requested cannot be found.</p>' . LF;
					echo INDENT . '<p>Maybe it has been moved or renamed... try browsing for it using the menu on the left hand side of this page.</p>' . LF;
					break;
			}

			// Standard page footer (counter)

			include('resources/bottom.php');
		?>
	</body>
</html>
