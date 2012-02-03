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
SOFTWARE
 */

namespace NetCore\Configurable;

/**
 * Author: Szymon Wygnański
 * Date: 06.09.11
 * Time: 04:03
 */
class StaticConfigurator
{

    static public function setOptions($target, $options)
    {
        if ($options instanceof Options) {
            $options = $options->getOptions();
        }

        if (!$options) {
            return;
        }

        foreach ($options as $opt => $optValue) {
            $opt = self::toCamelCased($opt);
            $setter = 'set' . $opt;
            if (method_exists($target, $setter)) {
                $target->$setter($optValue);
            }
        }
    }

    static public function toCamelCased($string)
    {
        return lcfirst(self::toPascalCased($string));
    }

    static public function toUnderscored($string)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }

    static public function toPascalCased($string)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    static public function writeIniFile($assoc_arr, $path, $has_sections = FALSE)
    {
        $content = '';
        $key2 = '';

        if ($has_sections) {
            foreach ($assoc_arr as $key => $elem) {
                $content .= '[' . $key . ']' . PHP_EOL;
                foreach ($elem as $key2 => $elem2) {
                    if (is_array($elem2)) {
                        for ($i = 0; $i < count($elem2); $i++) {
                            $content .= $key2 . '[] = \"' . $elem2[$i] . '\\n';
                        }
                    }
                    else if ($elem2 == '') $content .= $key2 . ' = \n';
                    else $content .= $key2 . ' = \"' . $elem2 . '\"\n';
                }
            }
        }
        else {
            foreach ($assoc_arr as $key => $elem) {
                if (is_array($elem)) {
                    for ($i = 0; $i < count($elem); $i++) {
                        $content .= $key2 . '[] = \"' . $elem[$i] . '\"\n';
                    }
                }
                else if ($elem == '') $content .= $key2 . ' = \n';
                else $content .= $key2 . ' = \"' . $elem . '\"\n';
            }
        }

        if (!$handle = fopen($path, 'w')) {
            return false;
        }

        if (!fwrite($handle, $content)) {
            return false;
        }

        fclose($handle);
        return true;
    }


}
