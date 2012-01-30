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
 * @time: 10:11
 */
class Script extends ComponentAbstract
{

    /**
     * @static
     * @param array $options
     * @return \NetCore\Component\Header\Script
     */
    static public function factory($options = array())
    {
        return new Script($options);
    }

    public function render()
    {
        $content = $this->getContent();
        if(empty($content)) {
            $ieVersion = $this->getIEMaxVersion();
            $type = $this->getType();
            $src = $this->getSrc();
            $out = '<script type="' . $type . '" src="' . $src . '"></script>';
            if($ieVersion) {
                $out = PHP_EOL . '<!--[if lt IE ' . $ieVersion . ']>' . PHP_EOL . $out . PHP_EOL . '<![endif]-->' . PHP_EOL;
            }
            return $out;
        }
        return '<script type="text/javascript">' . PHP_EOL . $content . PHP_EOL . '</script>';
    }

    /**
     * @param string $value
     * @return \NetCore\Component\Header\Script
     */
    public function setIEMaxVersion($value)
    {
        $this->options['ie_max_version'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getIEMaxVersion()
    {
        return empty($this->options['ie_max_version']) ? '' : $this->options['ie_max_version'];
    }


    /**
     * @param string $value
     * @return \NetCore\Component\Header\Script
     */
    public function setContent($value)
    {
        $this->options['content'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return empty($this->options['content']) ? '' : $this->options['content'];
    }


    /**
     * @param string $value
     * @return \NetCore\Component\Header\Script
     */
    public function setType($value)
    {
        $this->options['type'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return empty($this->options['type']) ? 'text/javascript' : $this->options['type'];
    }

    /**
     * @param string $value
     * @return \NetCore\Component\Header\Script
     */
    public function setSrc($value)
    {
        $this->options['src'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return empty($this->options['src']) ? '' : $this->options['src'];
    }

}
