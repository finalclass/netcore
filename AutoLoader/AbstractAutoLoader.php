<?php
/**

Copyright (C) Szymon Wygnanski (s@finalclass.net)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */

namespace NetCore\AutoLoader;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.03.12
 * @time: 10:56
 */
abstract class AbstractAutoLoader
{

	static private $paths = array();

	public function addIncludePath($path)
	{
		self::$paths[$path] = true;
	}

	public function removeIncludePath($path)
	{
		unset(self::$paths[$path]);
	}

	public function getIncludePaths()
	{
		return self::$paths;
	}

	public function register()
	{
		\spl_autoload_register(get_called_class() . '::autoload');
	}

	public function unregister()
	{
		\spl_autoload_unregister(get_called_class() . '::autoload');
	}

	abstract public function autoload($className);

}
