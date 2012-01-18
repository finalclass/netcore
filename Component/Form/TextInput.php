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

    protected function render()
    {
        echo '<input type="text" '
             . $this->renderTagAttributes(array('name', 'class', 'id', 'value', 'style'))
             . '/>';
    }

    

}
