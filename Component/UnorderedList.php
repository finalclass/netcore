<?php

namespace NetCore\Component;

use \NetCore\Component\Tag;

/**
 * Author: Szymon Wygnański
 * Date: 11.09.11
 * Time: 23:31
 */
class UnorderedList extends Tag
{
    
    public function getTagName()
    {
        return 'ul';
    }

    public function getContent()
    {
        $out = array();
        foreach($this->getChildren() as $child) {
            $out[] = '<li>' . $child . '</li>';
        }
        return join(PHP_EOL, $out);
    }

    public function setArrayAsContent($array) {
        foreach($array as $item) {
            $this->addChild(Text::factory()->setText($item));
        }
        return $this;
    }

}
