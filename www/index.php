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

			//$non_xhtml_compliant="no";

			include('resources/top.php');

			// Display the news

			echo INDENT . 'Have some news to tell us about? Then <a href="http://www.logiqx.com/forum/viewforum.php?f=15">submit news</a> here!' . LF ;

			$template = "CAESAR";
			include("cutenews/show_news.php");
			//include("cutenews/show_archives.php");

			echo '<p><a title="RSS Feed" href="cutenews/rss.php">';
			echo '<img src="cutenews/skins/images/rss_icon.gif" alt="rss" />';
			echo '</a></p>';

			// Standard page footer (counter)

			include('resources/bottom.php');
		?>
	</body>
</html>
