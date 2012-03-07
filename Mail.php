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

use \NetCore\Configurable\StaticConfigurator;

class Mail extends \Zend_Mail {

    /**
     *
     * @return \NetCore\Mail
     */
    static public function factory() {
        return new Mail();
    }

    /**
     *
     * @param array $options
     */
    public function __construct($options = array())
    {
        StaticConfigurator::setOptions($this, $options);
        if(!isset($options['charset'])) {
            $options['charset'] = 'utf-8';
        }
        parent::__construct($options['charset']);
    }


    /**
     *
     * @param string $html
     * @param string $charset
     * @param string $encoding
     * @return \NetCore\Mail
     */
    public function setBodyHtml($html, $charset = 'utf-8', $encoding = \Zend_Mime::ENCODING_QUOTEDPRINTABLE) {
        return parent::setBodyHtml($html, $charset, $encoding);
    }

    /**
     *
     * @param string $txt
     * @param string $charset
     * @param string $encoding
     * @return \NetCore\Mail
     */
    public function  setBodyText($txt, $charset = 'utf-8', $encoding = \Zend_Mime::ENCODING_QUOTEDPRINTABLE) {
        return parent::setBodyText($txt, $charset, $encoding);
    }

}