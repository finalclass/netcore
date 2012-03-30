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
namespace NetCore\ViewCompiler\ViewReflection;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.03.12
 * @time: 17:06
 */
class MetadataTagDefinition
{

	/** @var string */
	private $tagName;

	/**
	 * key=>value hash with metadata tag properties
	 *
	 * @var array
	 */
	private $properties;

	/** @var string */
	private $defaultProperty;

	public function __construct($tagName, $properties = array(), $defaultProperty = '')
	{
		$this->tagName = @(string)$tagName;
		$this->properties = @(array)$properties;
		$this->defaultProperty = @(string)$defaultProperty;
	}

	/**
	 * @return string
	 */
	public function getTagName()
	{
		return $this->tagName;
	}

	/**
	 * @return array
	 */
	public function getProperties()
	{
		return $this->properties;
	}

	/**
	 * @return string
	 */
	public function getDefaultProperty()
	{
		return $this->defaultProperty;
	}

}
