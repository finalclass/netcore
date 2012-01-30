<?php

namespace NetCore\Component\Form;

use \NetCore\Component\Form\FormElementAbstract;

/**
 * Author: Szymon Wygnański
 * Date: 12.09.11
 * Time: 04:11
 */
class TextArea extends FormElementAbstract
{

    protected $defaultAttributes = array('id', 'class', 'style', 'name', 'cols', 'rows', 'placeholder');

    /**
     * @param string $value
     * @return \NetCore\Component\Form\TextArea
     */
    public function setPlaceholder($value)
    {
        $this->options['placeholder'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return empty($this->options['placeholder']) ? '' : $this->options['placeholder'];
    }

    public function getTagName()
    {
        return 'textarea';
    }

    public function setValue($value)
    {
        $this->setContent($value);
    }

    public function getValue()
    {
        return $this->getContent();
    }
    
    public function getContent()
    {
        return strlen(trim(parent::getContent())) == 0 ? parent::getValue() : parent::getContent();
    }

    /**
     * @param $value
     * @return TextArea
     */
    public function setCols($value)
    {
        $this->options['cols'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getCols()
    {
        return isset($this->options['cols']) ? $this->options['cols'] : 40;
    }

    /**
     * @param $value
     * @return TextArea
     */
    public function setRows($value)
    {
        $this->options['rows'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getRows()
    {
        return isset($this->options['rows']) ? $this->options['rows'] : 10;
    }


}
