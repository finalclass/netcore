<?php

namespace NetCore\Component;

use \NetCore\Component\ComponentAbstract;

/**
 * Author: Szymon Wygnański
 * Date: 07.09.11
 * Time: 03:42
 */
class Title extends ComponentAbstract
{

    /**
     * @var string[]
     */
    private $titles = array();

    /**
     * @static
     * @param string $optionsOrTagName
     * @return Title
     */
    static public function factory($optionsOrTagName = 'title')
    {
        return new Title();
    }

    protected function render()
    {
        return '<title>' . join($this->getSeparator(), $this->titles) . '</title>';
    }

    /**
     * @param $title
     * @return Title
     */
    public function addTitle($title)
    {
        $this->titles[] = $title;
        return $this;
    }

    /**
     * @param $value
     * @return Title
     */
    public function setSeparator($value)
    {
        $this->options['separator'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSeparator()
    {
        return isset($this->options['separator']) ? $this->options['separator'] : ' - ';
    }
}
