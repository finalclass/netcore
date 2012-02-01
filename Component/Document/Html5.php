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

namespace NetCore\Component\Document;

use \NetCore\Component\Container;
use \NetCore\Component\Header\Title;
use \NetCore\Component\Header\Keywords;
use \NetCore\Component\Header\StyleSheets;
use \NetCore\Component\Header\Scripts;
use \NetCore\Component\Tag;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.01.12
 * @time: 08:58
 *
 * @property \NetCore\Component\Header\Title $title
 * @property \NetCore\Component\Header\Keywords $keywords
 * @property \NetCore\Component\Header\StyleSheets $styleSheets
 * @property \NetCore\Component\Header\Scripts $scripts
 * @property \NetCore\Component\Tag $body
 */
class Html5 extends Container
{
    public function __construct($options = array())
    {
        $this->keywords = new Keywords();
        $this->styleSheets = new StyleSheets();
        $this->scripts = new Scripts();
        $this->body = new Tag('body');
        $this->title = new Title();
        parent::__construct($options);
    }

    /**
     * @param string $value
     * @return \NetCore\Component\Document\Html5
     */
    public function setLang($value)
    {
        $this->options['lang'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return empty($this->options['lang']) ? 'en' : $this->options['lang'];
    }

    /**
     * @param string $value
     * @return \NetCore\Component\Html5
     */
    public function setMetaDescription($value)
    {
        $this->options['meta_description'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return empty($this->options['meta_description']) ? '' : $this->options['meta_description'];
    }


    public function render()
    {
        ?>
    <!DOCTYPE html>
    <html lang="<?php echo $this->getLang(); ?>">
    <head>
        <?php echo $this->title; ?>
        <?php echo $this->keywords; ?>
        <meta name="description" content="<?php echo $this->getMetaDescription(); ?>">
        <meta charset="utf-8"/>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <?php echo $this->styleSheets; ?>
        <?php echo $this->scripts; ?>
    </head>
        <?php echo $this->body; ?>
    </html>
    <?php
    }

}
