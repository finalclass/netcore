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

use \NetCore\Component\Container;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.01.12
 * @time: 09:35
 */
class StyleSheets extends Container
{

    protected $links = array();

    protected $styles = array();

    protected function beforeRender()
    {
        foreach ($this->links as $link) {
            $this->addChild($link);
        }
        $this->addChild(StyleSheet::factory()->setContent(join(PHP_EOL, $this->styles)));
    }

    public function appendLink($href, $media = 'screen', $ieMaxVersion = null)
    {
        $this->links[] = StyleSheet::factory()->setHref($href)->setMedia($media)->setIEMaxVersion($ieMaxVersion);
        return $this;
    }

    public function prependLink($href, $media = 'screen', $ieMaxVersion = null)
    {
        array_unshift($this->links,
            StyleSheet::factory()->setHref($href)->setMedia($media)->setIEMaxVersion($ieMaxVersion));
        return $this;
    }

    public function appendCss($cssString)
    {
        $this->styles[] = $cssString;
        return $this;
    }

    public function prependCss($cssString)
    {
        array_unshift($this->styles, $cssString);
        return $this;
    }


}
