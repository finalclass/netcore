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


class Route implements \Zend_Filter_Interface {

    public function filter($value) {
        return self::generate($value);
    }

    /**
     * @param  string $value
     * @return string
     */
    public static function generate($value) {
        $chars          = array('ł‚', 'ń', 'ą', 'ę', 'ś', 'ć', 'ó', 'ż', 'ź', 'Ł', 'Ń', 'Ą', 'Ę', 'Ś', 'Ć', 'Ó', 'Ż', 'Ź', '!', '.', ':', ',');
        $charsChange    = array('l', 'n', 'a', 'e', 's', 'c', 'o', 'z', 'z', 'L', 'N', 'A', 'E', 'S', 'C', 'O', 'Z', 'Z', '', '', '', '');

        $value = \Zend_Filter::filterStatic(str_replace($chars, $charsChange, $value), 'StringTrim');

        $filter = new \Zend_Filter();
        $filter->addFilter(new \Zend_Filter_StringToLower())
                ->addFilter(new \Zend_Filter_PregReplace('#([^a-zA-Z0-9\-])#i', ''));

        $array = explode(' ', $value);
        $count = count($array);
        $i = 0;
        $string = '';
        foreach ($array as $item) {
            if (strlen($item) > 0) {
                $line = ( $i < $count - 1 ) ? '-' : '';
                $string .= $filter->filter($item) . $line;
            }
            $i++;
        }
        return (string) $string;
    }

}