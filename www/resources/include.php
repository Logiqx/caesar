<?php
	// Formatting constants

	define ('INDENT', "\t\t\t\t\t");
	define ('LF', "\n");
	define ('TAB', "\t");

	// Database connection details

	define ('DB_HOST', 'localhost');
	define ('DB_NAME', 'lac_caesar');
	define ('DB_USER', 'lac_php');
	define ('DB_PASS', '');

	// Make the connection

	$dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASS) or die ('Could not connect to MySQL: ' . mysql_error());

	// Select the database

	@mysql_select_db (DB_NAME) or die ('Could not select the database: ' . mysql_error());

	// Function to output a question mark if variable is NULL

	function ifnull_qmark($text)
	{
		if (isset($text))
			return $text;
		else
			return '?';
	}

	// Determine where the www root is

	$www_root="";

	for ($i=0; $i<(substr_count($_SERVER['REQUEST_URI'], '/') - 1); $i++)
	{
		$www_root=$www_root . '../';
	}
?>
