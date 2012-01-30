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
 * @time: 09:38
 */
class StyleSheet extends ComponentAbstract
{

    /**
     * @static
     * @param array $options
     * @return StyleSheet
     */
    static public function factory($options = array())
    {
        return new StyleSheet($options);
    }

    public function render()
       {
           $content = $this->getContent();
           if(empty($content)) {
               $ieVersion = $this->getIEMaxVersion();
               $out = '<link media="' . $this->getMedia() . '" href="' . $this->getHref() . '" rel="stylesheet" type="text/css" />';
               if($ieVersion) {
                   $out = PHP_EOL . '<!--[if lt IE ' . $ieVersion . ']>' . PHP_EOL . $out . PHP_EOL . '<![endif]-->' . PHP_EOL;
               }
               return $out;
           }
           return '<style type="text/css">' . $this->getContent() . '</style>';
       }


    /**
     * @param string $value
     * @return \NetCore\Component\Header\StyleSheet
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
     * @return \NetCore\Component\Header\StyleSheet
     */
    public function setMedia($value)
    {
        $this->options['media'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getMedia()
    {
        return empty($this->options['media']) ? 'screen' : $this->options['media'];
    }

    /**
     * @param string $value
     * @return \NetCore\Component\Header\StyleSheet
     */
    public function setHref($value)
    {
        $this->options['kref'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return empty($this->options['kref']) ? '' : $this->options['kref'];
    }

    /**
     * @param string $value
     * @return \NetCore\Component\Header\StyleSheet
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


    
}
