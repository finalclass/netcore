<?php

namespace NetCore\Component\Form;

use \NetCore\Component\Tag;

/**
 * Author: Szymon Wygnański
 * Date: 09.09.11
 * Time: 02:23
 */
abstract class FormElementAbstract extends Tag
{

    /**
     * @static
     * @param string $optionsOrTagName
     * @return \Fc\Element\Form\FormElementAbstract
     */
    static public function factory($optionsOrTagName = 'input')
    {
        $class = get_called_class();
        return new $class($optionsOrTagName);
    }

    protected $defaultAttributes = array('id', 'class', 'style', 'name', 'value');

    /**
     * @param $value
     * @return \Fc\Layout\Element\Form\FormElementAbstract
     */
    public function setValue($value)
    {
        $this->options['value'] = $value;
        return $this;
    }

    public function getValue()
    {
        return isset($this->options['value']) ? $this->options['value'] : $this->getPostValue();
    }

    /**
     * @param $value
     * @return FormElementAbstract
     */
    public function setName($value)
    {
        $this->options['name'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return isset($this->options['name']) ? $this->options['name'] : '';
    }

    public function getPostValue()
    {
        return '';
    }


    
}
