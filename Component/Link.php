<?php

namespace NetCore\Component;

use \NetCore\Component\Tag;

/**
 * Author: Szymon Wygnański
 * Date: 09.09.11
 * Time: 16:35
 */
class Link extends Tag
{

    protected $defaultAttributes = array(
        'href', 'id', 'title', 'class', 'style', 'rel'
    );

    /**
     * @static
     * @param string|array $optionsOrTagName
     * @return Link
     */
    static public function factory($optionsOrTagName = 'div')
    {
        $class = get_called_class();
        return new $class($optionsOrTagName);
    }

    public function getTagName()
    {
        return 'a';
    }

   /**
    * @param $value
    * @return Link
    */
    public function setTitle($value)
    {
        $this->options['title'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return isset($this->options['title']) ? $this->options['title'] : '';
    }

    /**
     * @param $value
     * @return Link
     */
    public function setHref($value)
    {
        $this->options['href'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return isset($this->options['href']) ? $this->options['href'] : '#';
    }

    /**
     * @param $value
     * @return Link
     */
    public function setRel($value)
    {
        $this->options['rel'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getRel()
    {
        return isset($this->options['rel']) ? $this->options['rel'] : '';
    }

}
