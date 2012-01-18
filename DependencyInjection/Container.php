<?php

namespace NetCore\DependencyInjection;
use NetCore\DependencyInjection\Exception\ItemNotFound as ItemNotFoundException;

/**
 * Author: Szymon Wygnański
 * Date: 06.09.11
 * Time: 03:48
 */
class Container
{

    protected $items = array();

    public function __set($key, $value)
    {
        $this->items[$key] = $value;
    }

    public function __get($key)
    {
        if (!isset($this->items[$key])) {
            throw new ItemNotFoundException(sprintf('Value "%s" is not defined.', $key));
        }

        return is_callable($this->items[$key]) ? $this->items[$key]($this) : $this->items[$key];
    }

    public function share($callable)
    {
        return function ($di) use ($callable)
        {
            static $object;
            if (is_null($object)) {
                $object = $callable($di);
            }
            return $object;
        };
    }

    public function shareAndConfigure($className, $options)
    {
        return function ($di) use ($className, $options)
        {
            static $object;
            if (is_null($object)) {
                $object = new $className($options);
            }
            return $object;
        };
    }

    public function instantiate($className)
    {
        return function($di) use($className)
        {
            return new $className();
        };
    }

    public function configurable($callable, $options)
    {
        return function($di) use($callable, $options)
        {
            return new $callable($options);
        };
    }

    public function __invoke($item = null)
    {
        if($item == null) {
            return $this;
        }

        return $this->$item;
    }

    public function __call($name, $arguments)
    {
        /**
         * @var \Closure $helper
         */
        $helper = $this->$name;
        return $helper(array_pop($arguments));
    }

    public function exists($item)
    {
        return isset($this->items[$item]);
    }
}







