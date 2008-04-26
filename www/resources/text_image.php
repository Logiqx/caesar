<?php
	/*
		text_image() is based on some code that I found via http://www.alistapart.com/articles/dynatext:

		Dynamic Heading Generator
		By Stewart Rosenberger
		http://www.stewartspeak.com/headings/	

		Additional documentation on PHP's image handling capabilities can
		be found at http://www.php.net/image/	
	*/


	/*
		get_dip() will try to determine the "dip" (pixels dropped below baseline) of this
		font for this size.
	*/

	function get_dip($font, $size)
	{
		$test_chars = 'abcdefghijklmnopqrstuvwxyz' .
				'ABCDEFGHIJKLMNOPQRSTUVWXYZ' .
				'1234567890' .
				'!@#$%^&*()\'"\\/;.,`~<>[]{}-+_-=';
		$box = ImageTTFBBox($size, 0, $font, $test_chars);
		return $box[3];
	}


	/* 
		hex_to_rgb() decodes an HTML hex-code into an array of R, G, and B values.
		accepts these formats: (case insensitive) #ffffff, ffffff, #fff, fff 
	*/	


	function hex_to_rgb($hex)
	{
		// remove '#'
		if (substr($hex, 0, 1) == '#')
			$hex = substr($hex, 1);

		// expand short form ('fff') color
		if (strlen($hex) == 3)
		{
			$hex = substr($hex, 0, 1) . substr($hex, 0, 1) .
				substr($hex, 1, 1) . substr($hex, 1, 1) .
				substr($hex, 2, 1) . substr($hex, 2, 1);
		}

		// convert
		if (strlen($hex) == 6)
		{
			$rgb['red'] = 0;
			$rgb['green'] = 0;
			$rgb['blue'] = 0;
		}
		else
		{
			$rgb['red'] = hexdec(substr($hex, 0, 2));
			$rgb['green'] = hexdec(substr($hex, 2, 2));
			$rgb['blue'] = hexdec(substr($hex, 4, 2));
		}

		return $rgb;
	}


	/*
		create_image_text() is the main bit of code
	*/

	function text_image($text)
	{
		$font_file = '../resources/lettera32.ttf';
		$font_size = 18;
		$font_color = '#000000';
		$background_color = '#ffffff';
		$transparent_background = true;

		$cache_folder = '../cache';
		$extension = '.png';

		// Determine the filename for the image
		$hash = md5(basename($font_file) . $font_size . $font_color .
				$background_color . $transparent_background . $text);
		$cache_filename = $cache_folder . '/' . $hash . $extension;

		// If the image file does not exist, create it
		if (function_exists('ImageCreate') and !is_readable($cache_filename))
		{

			// create image
			$background_rgb = hex_to_rgb($background_color);
			$font_rgb = hex_to_rgb($font_color);
			$dip = get_dip($font_file, $font_size);
			$box = ImageTTFBBox($font_size, 0, $font_file, $text);
			$image = ImageCreate(abs($box[2] - $box[0]), abs($box[5] - $dip));

			// allocate colors and draw text
			$background_color = ImageColorAllocate($image,$background_rgb['red'],
				$background_rgb['green'], $background_rgb['blue']);
			$font_color = ImageColorAllocate($image, $font_rgb['red'],
				$font_rgb['green'], $font_rgb['blue']);
			ImageTTFText($image, $font_size, 0, -$box[0], abs($box[5] - $box[3]) - $box[1],
				$font_color, $font_file, $text);
	
			// set transparency
			if ($transparent_background)
				ImageColorTransparent($image, $background_color);
	
			// save copy of image for cache
			ImagePNG($image, $cache_filename);
	
			ImageDestroy($image);
		}
	
		return $cache_filename;
	}
?>

