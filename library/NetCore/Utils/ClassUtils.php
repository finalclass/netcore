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
 * @date: 20.03.12
 * @time: 09:07
 */
class ClassUtils
{

    static public function getAncestorsClass($className)
    {
        $father = get_parent_class($className);
        $ancestors = array();
        if ($father != '') {
            $ancestors = self::getAncestorsClass($father);
            $ancestors[] = $father;
        }
        return $ancestors;
    }

    static public function getAncestorsClassUntil($className, $oldestAncestorClassName)
    {
        $father = get_parent_class($className);
        $ancestors = array();
        if ($father != '' && is_subclass_of($father, $oldestAncestorClassName)) {
            $ancestors = self::getAncestorsClassUntil($father, $oldestAncestorClassName);
            $ancestors[] = $father;
        }
        return $ancestors;
    }

}
