<?php

namespace NetCore\Component;

use \NetCore\Component\Tag;

/**
 * Author: Szymon Wygnański
 * Date: 12.09.11
 * Time: 00:41
 */
class HeadLinks extends Tag
{

    private $files = array();

    private $styles = '';

    public function render()
    {
        foreach($this->files as $file) {
            echo '<link rel="stylesheet" type="text/css" href="' . $file. '" />';
        }
        if(!empty($this->styles)) {
            echo '<style type="text/css">' . PHP_EOL
                    .  $this->styles . PHP_EOL
                 . '</style> ';
        }
    }

    public function appendFile($file)
    {
        $this->files[$file] = $file;
    }

    public function appendScript($text)
    {
        $this->styles .= $text . PHP_EOL;
    }

    public function getTagName()
    {
        return 'link';
    }

}
