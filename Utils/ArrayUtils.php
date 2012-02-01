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

/**
 * @author: Sel <s@finalclass.net>
 * @date: 01.02.12
 * @time: 00:26
 */
class ArrayUtils
{
    /**
     * difference between this function and array_merge_recursive is:
     * $this->arrayMergeRecursiveSimple(array('aa' => 2), array('aa' => '3'))
     * returns array('aa' => 3) not array('aa' => array(2, 3));
     *
     * @return array
     */
    static public function arrayMergeRecursiveSimple()
    {
        if (func_num_args() < 2) {
            trigger_error(__FUNCTION__ . ' needs two or more array arguments', E_USER_WARNING);
            return null;
        }
        $arrays = func_get_args();
        $merged = array();
        while ($arrays) {
            $array = array_shift($arrays);
            if (!is_array($array)) {
                trigger_error(__FUNCTION__ . ' encountered a non array argument', E_USER_WARNING);
                return null;
            }
            if (!$array)
                continue;
            foreach ($array as $key => $value)
                if (is_string($key))
                    if (is_array($value) && array_key_exists($key, $merged) && is_array($merged[$key]))
                        $merged[$key] = self::arrayMergeRecursiveSimple($merged[$key], $value);
                    else
                        $merged[$key] = $value;
                else
                    $merged[] = $value;
        }
        return $merged;
    }
}
