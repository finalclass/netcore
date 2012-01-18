<?php

namespace NetCore\Doctrine;

/**
 * Author: Szymon Wygnański
 * Date: 12.09.11
 * Time: 17:35
 */
abstract class EntityAbstract implements \ArrayAccess
{
    public function offsetExists($offset) {
        // In this example we say that exists means it is not null
        $value = $this->{"get$offset"}();
        return $value !== null;
    }

    public function offsetSet($offset, $value) {
        throw new \BadMethodCallException("Array access of class " . get_class($this) . " is read-only!");
    }

    public function offsetGet($offset) {
        return $this->{"get$offset"}();
    }

    public function offsetUnset($offset) {
        throw new \BadMethodCallException("Array access of class " . get_class($this) . " is read-only!");
    }

}