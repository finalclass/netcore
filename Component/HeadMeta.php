<?php

namespace NetCore\Component;

use \NetCore\Component\Tag;

/**
 * Author: Szymon Wygnański
 * Date: 12.09.11
 * Time: 00:42
 */
class HeadMeta extends Tag
{

    private $metas = array();

    public function render()
    {
        foreach($this->metas as $name=>$meta) {
            $content = empty($meta['content']) ? '' : ' content="' . $meta['content'] . '" ';
            $httpEquiv = empty($meta['http_equiv']) ? '' : ' http-equiv="' . $meta['http_equiv'] . '" ';
            echo '<meta name="' . $name . '" ' . $content . $httpEquiv . '" />';
        }
    }

    public function addName($name, $content, $httpEquiv)
    {
        $this->metas[$name] = array('content' => $content, 'http_equiv' => $httpEquiv);
        return $this;
    }

    public function getTagName()
    {
        return 'meta';
    }

}
