<?php

namespace NetCore\Component\Form;

use \NetCore\Component\Form\FormElementAbstract;

/**
 * Author: Misiorus Maximus
 */
class Password extends FormElementAbstract
{

    protected function render()
    {
        echo '<input type="password" '
             . $this->renderTagAttributes(array('name', 'class', 'id', 'value', 'style'))
             . '/>';
    }

    

}