<?php
/**

Copyright (C) Szymon Wygnanski (s@finalclass.net)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */
namespace NetCore\Utils\ArrayUtils;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 23.04.12
 * @time: 14:58
 */
class ArrayCollection implements \IteratorAggregate, \ArrayAccess, \Serializable, \Countable
{

    protected $options = array();
    protected $maxSort = 0;
    protected $minSort = -1;
    protected $isDirty = false;

    public function __construct(&$options = array())
    {
        $this->options = &$options;
    }

    public function toArray()
    {
        return $this->options;
    }

    public function append($filePath)
    {
        $this->set($this->maxSort++, (string)$filePath);
        return $this;
    }

    public function prepend($filePath)
    {
        $this->set($this->minSort--, (string)$filePath);
        return $this;
    }

    /**
     * WARNING
     * You are not changing maxSort and minSort!!!
     *
     * @param $position
     * @param $filePath
     * @return \NetCore\Utils\ArrayCollection
     */
    protected function set($position, $filePath)
    {
        $this->isDirty = true;
        $this->options[$position] = (string)$filePath;
        return $this;
    }


    public function has($filePath)
    {
        foreach ($this->options as $file) {
            if ($file == $filePath) {
                return true;
            }
        }
        return false;
    }

    public function remove($filePath)
    {
        $filePath = (string)$filePath;
        $count = count($this->options);
        for ($i = 0; $i < $count; $i++) {
            $current = $this->options[$i];
            if ($current == $filePath) {
                unset($this->options[$i]);
            }
        }
        $this->options = array_values($this->options);
        return $this;
    }

    public function getUnique()
    {
        if ($this->isDirty) {
            $this->options = array_unique($this->options);
            ksort($this->options);
        }
        return $this->options;
    }

    /**
     * Traversable
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->options);
    }

    /**
     * ArrayAccess
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->options[$offset]);
    }

    /**
     * ArrayAccess
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->options[$offset];
    }

    /**
     * ArrayAccess
     * @param string $offset
     * @param $value
     */
    public function offsetSet($offset, $value)
    {
        $this->options[$offset] = $value;
    }

    /**
     * ArrayAccess
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->options[$offset]);
    }

    /**
     * Serializable
     * @return string
     */
    public function serialize()
    {
        return serialize($this->options);
    }

    /**
     * Serializable
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->options = unserialize($serialized);
    }

    /**
     * Countable
     * @return int
     */
    public function count()
    {
        return count($this->options);
    }


}
