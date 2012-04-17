<?php

namespace NetCore\Configurable\DynamicObject;

/**
 * Author: Szymon Wygnański
 * Date: 14.09.11
 * Time: 20:44
 */
class Reader
{

    protected $target = '';

    private $lastRandomItem;

    public function __construct(&$target = array())
    {
        $this->target = &$target;
    }

    public function setTarget(&$target)
    {
        $this->target = &$target;
        return $this;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        if( empty($this->target) or !is_array($this->target) ) {
            return array();
        }
        return (array) $this->target;
    }

    public function toArray()
    {
        return $this->getArray();
    }

    public function getInt() {
        if(is_array($this->target)) {
            return 0;
        }
        return (int) $this->target;
    }

    public function getString() {
        if( is_array($this->target) ) {
            return '';
        }
        return (string) $this->target;
    }

    public function toString()
    {
        return $this->getString();
    }

    public function trimStripTags()
    {
        return strip_tags(trim($this->getString()));
    }

    public function setValue(&$target = array())
    {
        $this->target = &$target;
        return $this;
    }

    public function getValue()
    {
        return $this->target;
    }

    public function getDifferentButRandom()
    {
        if(is_string($this->target)) {
            return $this->target;
        }
        $array = (array)$this->target;
        $randMax = count($array)-1;
        do {
            $item = rand(0, $randMax);
        } while($item == $this->lastRandomItem);
        $this->lastRandomItem = $item;
        return $this->target[$item];

    }

    public function __get($name)
    {
        /**
         * @var Reader $class;
         */
        
        $class = get_called_class();
        $reference = ( is_array($this->target) && isset($this->target[$name]) )
                ? $this->target[$name] : '';
        return new $class($reference);
    }

    public function exists()
    {
        return $this->target == true;
    }

    public function __toString()
    {
        if(is_string($this->target)) {
            return $this->target;
        }
        return '';
    }

    public function __invoke($name, $default = '')
    {
        if(!is_string($name)) {
            return $this;
        }

        $class = get_called_class();
        if(empty($this->target[$name])) {
            return new $class($default);
        } else if(is_array($this->target[$name])) {
            return new $class($this->target[$name]);
        } else {
            return $this->target[$name];
        }
    }

    public function __call($name, $arguments = array())
    {

        /**
         * @var \Reader $item
         */

        $item = $this->$name;

        switch(count($arguments)) {
            case 0:
                return $item;
                break;
            case 1:
                $subItemName = $arguments[0];
                return $item->$subItemName;
                break;
            case 2: default:
                $subItemName = $arguments[0];
                $defaultValue = $arguments[1];
                return $item($subItemName, $defaultValue);
                break;
        }
    }
    
}
