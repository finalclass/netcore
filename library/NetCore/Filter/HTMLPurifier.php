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

namespace NetCore\Filter;

use \HTMLPurifier as BasePurifier;

class HTMLPurifier implements \Zend_Filter_Interface
{

	/**
	 *
	 * @var \HTMLPurifier
	 */
	static private $purifier = null;

	public function  __construct($options = array()) {
		if(self::$purifier !== null)
			return;

		\HTMLPurifier_Bootstrap::registerAutoload();
		$config = \HTMLPurifier_Config::createDefault();

		foreach($options as $key=>$val)
		{
			if($val === '1' || $val === '')
				$val = (bool) $val;
			$config->set(str_replace('_', '.', $key), $val);

		}

		self::$purifier = new \BasePurifier($config);
	}

	public function setOption($key, $value)
	{
		self::$purifier->config->set($key, $value);
	}

	public function getOption($key)
	{
		return self::$purifier->config->get($key);
	}

	public function  filter($value)
	{
		return self::$purifier->purify($value);
	}

	static public function staticFilter($value)
	{
		$filter = new HTMLPurifier();
		return $filter->filter($value);
	}

}