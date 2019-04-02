<?php
	// Formatting constants

	define ('INDENT', "\t\t\t\t\t");
	define ('LF', "\n");
	define ('TAB', "\t");

	// Database connection details

	define ('DB_HOST', 'mysql');
	define ('DB_NAME', 'lac_caesar');
	define ('DB_USER', 'lac_php');
	define ('DB_PASS', 'r34d0nly');

	// Make the connection

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (!$mysqli)
	{
		echo "Failed to connect to MySQL: (" . mysqli_connect_errno() . ") " . mysqli_connect_error();
	}

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

	if ($www_root == "")
	{
		$www_root = "/";
	}
?>
