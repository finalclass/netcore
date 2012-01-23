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

namespace NetCore;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 23.01.12
 * @time: 10:54
 */
class Renderer
{

    public static function renderVariable($variable, $customArgument = null, $context = null)
    {
        $out = '';

        if (method_exists($variable, '__toString')) {
            $out .= $variable;
        } else if (is_string($variable)) {
            $out .= $variable;
        } else if (is_callable($variable)) {
            ob_start();
            $arguments = $context ? array($context) : array();
            if ($customArgument) {
                $arguments[] = $customArgument;
            }
            $out .= call_user_func_array($variable, $arguments);
            $out .= ob_get_clean();
        }
        return $out;
    }

}
