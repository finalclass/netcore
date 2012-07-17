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
use \NetCore\Utils\Words;

class ShrinkText implements \Zend_Filter_Interface {

	/**
	 *
	 * @var int
	 */
	private $_length = 100;
	/**
	 *
	 * @var String
	 */
	private $_suffixText = '...';

    /**
     * Sets the filter options
     * Allowed options are
     *     'length'     => Length to whitch value will be shrinked
     *     'suffixText'  => Text to concat to the shrinked text.
     *
     * @param  string|array|\Zend_Config $options
     * @return \NetCore\Filter\ShrinkText
     */
	public function __construct($options = array())
	{
		if ($options instanceof \Zend_Config) {
			$options = $options->toArray();
		} else if (!is_array($options)) {
			$options = func_get_args();
			$temp['length'] = array_shift($options);
			if (!empty($options)) {
				$temp['suffixText'] = array_shift($options);
			}

			$options = $temp;
		}

		if (array_key_exists('length', $options))
			$this->setLength($options['length']);
		if (array_key_exists('suffixText', $options))
			$this->setSuffixText($options['suffixText']);
	}

	/**
	 * Sets the maxlength to whitch value will be filtered
	 *
	 * @param int $length
	 * @throws \Exception when length is lower then 0
	 * @return \NetCore\Filter\ShrinkText
	 */
	public function setLength($length)
	{
		if( $length < 0 )
			throw new \Exception('Length cannot be lower then 0');
		$this->_length = $length;
		return $this;
	}

	/**
	 * Gets the maxlength to whitch value will be filtered
	 * 
	 * @return int
	 */
	public function getLength()
	{
		return $this->_length;
	}

	/**
	 * Sets the suffix text. This text will be added if given value will be shrinked.
	 * For example if value equels "abcdefg" and length set is 3 then this suffixText
	 * will be added. If set length is 10 then nothink is added.
	 *
	 * @param String $text
	 * @return \NetCore\Filter\ShrinkText
	 */
	public function setSuffixText($text)
	{
		$this->_suffixText = $text;
		return $this;
	}

	/**
	 * Returns text that will be added to the value if it is gonna be shrinked.
	 * Default is: "..."
	 *
	 * @return String
	 */
	public function getSuffixText()
	{
		return $this->_suffixText;
	}

	/**
	 * Returns text shrinked to the given length
	 *
	 * @param string $text
	 * @return string
	 */
	public function filter($text) {
        return Words::shrinkText($text, $this->getLength(), $this->getSuffixText());
	}

}