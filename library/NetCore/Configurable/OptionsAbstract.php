<?php

namespace NetCore\Configurable;

use \NetCore\Configurable\StaticConfigurator;
use \NetCore\Configurable\DynamicObject\Reader;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 06.09.11
 * Time: 04:08
 */
class OptionsAbstract
{

    protected $options = array();

    public function __construct($options = array())
    {
        if($options instanceof Reader) {
            $options = $options->getValue();
        }
        $this->setOptions($options);
    }

    public function setOptions($options = array())
    {
        StaticConfigurator::setOptions($this, $options);
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

}
