<?php

/**
 * Backslash
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2017 - 2018, Luci Production Team 
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	Backslash
 * @author	Luci Production Team
 * @copyright	Copyright (c) 2017 - 2018, Luci Production Team. (https://luciteam.com/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://backslash.xyz
 * @since	Version 1.0.0
 * @filesource
 */
 
 /*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 */

 define('ENV', isset($_SERVER['BS_ENV']) ? $_SERVER['BS_ENV'] : 'development');	

 /*
 *---------------------------------------------------------------
 * APPLICATION ERROR REPORTING
 *---------------------------------------------------------------
 */


 switch (ENV)
{
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>='))
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		}
		else
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
	break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}


/*
 *---------------------------------------------------------------
 * SET GLOBAL CONSTANTS
 *---------------------------------------------------------------
 */

 $program_path = 'program';


 $docs_path = 'docs';


 $bs_version = '1.0.0';


 $app_path = 'app';


 $program_kernel = $program_path.'/'.'kernel/Backslash.php';


 $show_path = '';


 // Set the current directory correctly for CLI requests
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (($_temp = realpath($program_path)) !== FALSE)
	{
		$program_path = $_temp.DIRECTORY_SEPARATOR;
	}
	else
	{
		// Ensure there's a trailing slash
		$program_path = strtr(
			rtrim($program_path, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		).DIRECTORY_SEPARATOR;
	}

	// Is the system path correct?
	if ( ! is_dir($program_path))
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your program folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
		exit(3); // EXIT_CONFIG
	}


	// The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// Path to the system directory
	define('ROOTPATH', $program_path);

	// Path to the front controller (this file) directory
	define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

	// Name of the "system" directory
	define('SYSDIR', basename(ROOTPATH));


	if (is_dir($app_path))
	{
		if (($_temp = realpath($app_path)) !== FALSE)
		{
			$app_path = $_temp;
		}
		else
		{
			$app_path = strtr(
				rtrim($app_path, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(ROOTPATH.$app_path.DIRECTORY_SEPARATOR))
	{
		$app_path = ROOTPATH.strtr(
			trim($app_path, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your app folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}

	define('APPPATH', $app_path.DIRECTORY_SEPARATOR);


	if ( ! isset($show_path[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
	{
		$show_path = APPPATH.'views';
	}
	elseif (is_dir($show_path))
	{
		if (($_temp = realpath($show_path)) !== FALSE)
		{
			$show_path = $_temp;
		}
		else
		{
			$show_path = strtr(
				rtrim($show_path, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(APPPATH.$show_path.DIRECTORY_SEPARATOR))
	{
		$show_path = APPPATH.strtr(
			trim($show_path, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your showing folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}

	define('VIEWPATH', $show_path.DIRECTORY_SEPARATOR);



	require_once $program_kernel;