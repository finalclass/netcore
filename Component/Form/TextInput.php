<?php

namespace NetCore\Component\Form;

use \NetCore\Component\Form\FormElementAbstract;

/**
 * Author: Szymon Wygnański
 * Date: 09.09.11
 * Time: 02:21
 */
class TextInput extends FormElementAbstract
{

    /**
     * @param string $value
     * @return \NetCore\Component\Form\TextInput
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

    public function render()
    {
        echo '<input type="text" '
             . $this->renderTagAttributes(array('name', 'class', 'id', 'value', 'style', 'placeholder'))
             . '/>';
    }

    

}
