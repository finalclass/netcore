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
namespace NetBricks\Common\HeaderConfig;

use \NetCore\Configurable\OptionsAbstract;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 20.03.12
 * @time: 13:02
 */
class Scripts extends OptionsAbstract
{

    public function append($filePath)
    {
        $this->options[] = $filePath;
        return $this;
    }

    public function prepend($filePath)
    {
        array_unshift($this->options, $filePath);
        return $this;
    }

    public function has($filePath)
    {
        foreach($this->options as $file) {
            if($file == $filePath) {
                return true;
            }
        }
        return false;
    }

    public function remove($filePath)
    {
        $count = count($this->options);
        for($i = 0; $i < $count; $i++) {
            $current = $this->options[$i];
            if($current == $filePath) {
                unset($this->options[$i]);
            }
        }
        $this->options = array_values($this->options);
        return $this;
    }

    public function getUnique()
    {
        return array_unique($this->options);
    }


}
