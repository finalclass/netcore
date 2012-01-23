<?php

namespace NetCore\Component;

use \NetCore\Component\ComponentAbstract;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 15.11.11
 * Time: 11:41
 */
class Container extends ComponentAbstract
{
    

    /**
     * @var \NetCore\Component\ComponentAbstract[]
     */
    protected $children = array();

    /**
     * @return string
     */
    public function render()
    {
        return join(PHP_EOL, $this->children);
    }

    /**
     * @param ComponentAbstract $child
     * @param string $childName
     * @return Container
     */
    public function addChild(ComponentAbstract $child, $childName = '')
    {
        if(empty($childName)) {
            $this->children[] = $child;
        } else {
            $this->children[$childName] = $child;
        }
        
        $child->setParent($this);
        return $this;
    }

    public function setChildren(array $children) {
        foreach($children as $childName => $child) {
            $this->addChild($child, $childName);
        }
        return $this;
    }

    public function getChildByName($name)
    {
        return isset($this->children[$name]) ? $this->children[$name] : '';
    }

    public function removeChild($childName)
    {
        if(isset($this->children[$childName])) {
            unset($this->children[$childName]);
        }
        return $this;
    }

    /**
     * @return array|ComponentAbstract[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function removeAllChildren()
    {
        $this->children = array();
        return $this;
    }

    public function recursiveDispatchEvent(\NetCore\Event\Event $event)
    {
        foreach($this->getChildren() as $child) {
            if($child instanceof Container) {
                $child->recursiveDispatchEvent($event);
            } else if($child instanceof ComponentAbstract) {
                $child->dispatchEvent($event);
            }
        }
        $this->dispatchEvent($event);
    }

    public function __get($name)
    {
        return isset($this->children[$name]) ? $this->children[$name] : '';
    }

    public function __set($name, $value)
    {
        $this->addChild($value, $name);
    }
    
}
