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
	 defined('ROOTPATH') OR exit('Rootpath required for execute code');

	 const BS_VER = '1.0.0';

 /*

 First load framework default and manualy constants from base folder (app/base/cons.php)

 */

 	if(file_exists(APPPATH.'base/'.ENV.'/cons.php')){

 		require_once APPPATH.'base/'.ENV.'/cons.php';
 	}
   

	if(file_exists(APPPATH.'base/cons.php')){

 		require_once APPPATH.'base/cons.php';
 	}


 /*

 Load framework default ectual function (program/kernel/Actual.php)

 */	

 	if(file_exists(ROOTPATH.'kernel/Actual.php')){

 		require_once ROOTPATH.'kernel/Actual.php';
 	}



 /*
 

 Set some security options 


 */


 if( !is_version('5.4')){

 	ini_set('magic_quotes_runtime', 0);

	if ((bool) ini_get('register_globals'))
	{
		$_protected = array(
			'_SERVER',
			'_GET',
			'_POST',
			'_FILES',
			'_REQUEST',
			'_SESSION',
			'_ENV',
			'_COOKIE',
			'GLOBALS',
			'HTTP_RAW_POST_DATA',
			'program_path',
			'app_path',
			'show_folder',
			'_protected',
			'_registered'
		);

		$_registered = ini_get('variables_order');
		foreach (array('E' => '_ENV', 'G' => '_GET', 'P' => '_POST', 'C' => '_COOKIE', 'S' => '_SERVER') as $key => $superglobal)
		{
			if (strpos($_registered, $key) === FALSE)
			{
				continue;
			}

			foreach (array_keys($$superglobal) as $var)
			{
				if (isset($GLOBALS[$var]) && ! in_array($var, $_protected, TRUE))
				{
					$GLOBALS[$var] = NULL;
				}
			}
		}
	}


 }	

 	





