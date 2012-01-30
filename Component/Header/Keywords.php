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

namespace NetCore\Component\Header;

use \NetCore\Component\ComponentAbstract;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.01.12
 * @time: 09:25
 */
class Keywords extends ComponentAbstract
{

    protected $keywords = array();

    public function render()
    {
        return '<meta name="keywords" content="' . join(', ', $this->keywords) .'">';
    }


    /**
     * @param string|array $keywords
     * @return \NetCore\Component\Header\Keywords
     */
    public function add($keywords)
    {
        if(!is_array($keywords)) {
            $keywords = array($keywords);
        }

        foreach($keywords as $k) {
            $separated = explode(',', $k);
            if(count($separated) > 1) {
                $this->add($separated);
            } else {
                $this->keywords[trim($k)] = null;
            }
        }
        return $this;
    }

}
