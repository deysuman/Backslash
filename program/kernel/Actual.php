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


 if ( ! function_exists('is_version'))
{
	function is_version($version)
	{
		static $_is_version;
		$version = (string) $version;

		if ( ! isset($_is_version[$version]))
		{
			$_is_version[$version] = version_compare(PHP_VERSION, $version, '>=');
		}

		return $_is_version[$version];
	}
}



if ( ! function_exists('realy_writeable'))
{
	
	function realy_writeable($file)
	{
		if (DIRECTORY_SEPARATOR === '/' && (is_version('5.4') OR ! ini_get('safe_mode')))
		{
			return is_writable($file);
		}

		if (is_dir($file))
		{
			$file = rtrim($file, '/').'/'.md5(mt_rand());
			if (($fp = @fopen($file, 'ab')) === FALSE)
			{
				return FALSE;
			}

			fclose($fp);
			@chmod($file, 0777);
			@unlink($file);
			return TRUE;
		}
		elseif ( ! is_file($file) OR ($fp = @fopen($file, 'ab')) === FALSE)
		{
			return FALSE;
		}

		fclose($fp);
		return TRUE;
	}
}


if ( ! function_exists('is_class_loaded'))
{
	
	function &is_class_loaded($class, $directory = 'lib', $param = NULL)
	{
		static $_classes = array();

		if (isset($_classes[$class]))
		{
			return $_classes[$class];
		}

		$name = FALSE;

		foreach (array(APPPATH, ROOTPATH) as $path)
		{
			if (file_exists($path.$directory.'/'.$class.'.php'))
			{
				$name = 'BS_'.$class;

				if (class_exists($name, FALSE) === FALSE)
				{
					require_once($path.$directory.'/'.$class.'.php');
				}

				break;
			}
		}

		if (file_exists(APPPATH.$directory.'/'.config_item('subclass_prefix').$class.'.php'))
		{
			$name = config_item('subclass_prefix').$class;

			if (class_exists($name, FALSE) === FALSE)
			{
				require_once(APPPATH.$directory.'/'.$name.'.php');
			}
		}

		if ($name === FALSE)
		{
			set_status_header(503);
			echo 'Unable to locate the specified class: '.$class.'.php';
			exit(5);
		}

		is_loaded($class);

		$_classes[$class] = isset($param)
			? new $name($param)
			: new $name();
		return $_classes[$class];
	}
}

if ( ! function_exists('is_loaded'))
{
	function &is_loaded($class = '')
	{
		static $_is_loaded = array();

		if ($class !== '')
		{
			$_is_loaded[strtolower($class)] = $class;
		}

		return $_is_loaded;
	}
}



