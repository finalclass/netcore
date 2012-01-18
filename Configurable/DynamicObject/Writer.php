<?php

namespace NetCore\Configurable\DynamicObject;

use \NetCore\Configurable\DynamicObject\Reader;

/**
 * Author: Szymon Wygnański
 * Date: 14.09.11
 * Time: 20:47
 */
class Writer extends Reader
{

    public function __set($name, $value)
    {
        $this->target[$name] = $value;
    }

    public function __get($name)
    {

        if(is_string($this->target)) {
            return $this;
        }

        if(!isset($this->target[$name]) ) {
            $this->target[$name] = array();
        }

        $class = get_called_class();
        return new $class($this->target[$name], $name);
    }


}
