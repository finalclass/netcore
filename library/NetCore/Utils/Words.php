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

namespace NetCore\Utils;

class Words
{

    static public function generateWord($length = 8)
    {
        static $consonants = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'z');
        static $vowels = array('a', 'e', 'i', 'o', 'u', 'y');

        $word = '';
        $lastIsVowel = rand(0, 1) > 0.5;
        for ($i = 0; $i < $length; $i++) {
            $letters = $lastIsVowel ? $consonants : $vowels;
            $pos = rand(0, count($letters) - 1);
            $word .= $letters[$pos];
            $lastIsVowel = !$lastIsVowel;
        }
        return $word;
    }

    static public function shrinkText($text, $length = 100, $suffix = '...')
    {
        if ($length > strlen($text)) {
            return $text;
        }

        while (!isset($text[$length]) || $text[$length] != ' ' && $length != 0) {
            $length--;
        }

        return mb_substr($text, 0, $length) . $suffix;
    }

    static public function createGuid($value)
    {
        $chars = array('ł‚', 'ń', 'ą', 'ę', 'ś', 'ć', 'ó', 'ż', 'ź', 'Ł', 'Ń', 'Ą', 'Ę', 'Ś', 'Ć', 'Ó', 'Ż', 'Ź', '!', '.', ':', ',', '-');
        $charsChange = array('l', 'n', 'a', 'e', 's', 'c', 'o', 'z', 'z', 'L', 'N', 'A', 'E', 'S', 'C', 'O', 'Z', 'Z', '', '', '', '', ' ');

        $value = trim(str_replace($chars, $charsChange, $value));

        $filter = function($value)
        {
            $value = strtolower($value);
            $value = preg_replace('#([^a-zA-Z0-9\-])#i', '', $value);
            return $value;
        };

        $array = explode(' ', $value);
        $count = count($array);
        $i = 0;
        $string = '';
        foreach ($array as $item) {
            if (strlen($item) > 0) {
                $line = ($i < $count - 1) ? '-' : '';
                $string .= $filter($item) . $line;
            }
            $i++;
        }
        return (string)$string;
    }

}
