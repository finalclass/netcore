<?php

namespace NetCore\DependencyInjection;

use \NetCore\DependencyInjection\Container as DIContainer;

/**
 * Author: Szymon Wygnański
 * Date: 14.09.11
 * Time: 01:59
 */
class MutualContainer extends DIContainer
{

    /**
     * @var MutualContainer
     */
    static protected $instance;

    /**
     * @static
     * @return MutualContainer
     */
    static protected function getInstance()
    {
        if(!static::$instance) {
            $class = get_called_class();
            static::$instance = new $class();
        }
        return static::$instance;
    }

     public function __get($key)
     {
        if (!isset($this->items[$key])) {
            $containerClass = get_class($this);
            $this->items[$key] = new $containerClass();
        }
        return is_callable($this->items[$key])
                ? $this->items[$key]($this) : $this->items[$key];
    }

    public function get($key)
    {
        return $this->items[$key];
    }

    static public function __callStatic($name, $arguments)
    {
        $item = static::getInstance()->$name;
        return ( empty($arguments) || !is_callable($item) || get_class($item) == get_called_class())
                ? $item : call_user_func_array($item, $arguments);
    }

    static public function set($varName, $value)
    {
        self::getInstance()->$varName = $value;
        return self::$instance;
    }

    public function __invoke($item = null)
    {
        if(!is_string($item)) {
            return $this;
        }

        return $this->$item;
    }

    public function __call($name, $arguments)
    {
        $item = $this->$name;
        return is_callable($this->items[$name])
                ? call_user_func_array($item, $arguments) : $item;
    }

}
