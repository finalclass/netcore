<?php

namespace NetCore\DependencyInjection;

use \NetCore\DependencyInjection\Container;
use \NetCore\Configurable\StaticConfigurator;


/**
 * Author: Szymon Wygnański
 * Date: 08.09.11
 * Time: 01:06
 *
 */
class ConfigurableContainer extends Container
{

    public function __construct($options = array())
    {
        $this->setOptions($options);
    }

    public function setOptions($options = array())
    {
        StaticConfigurator::setOptions($this, $options);
    }

    public function getOptions()
    {
        return $this->options;
    }


}
