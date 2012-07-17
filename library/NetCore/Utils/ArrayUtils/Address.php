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
 * @time: 14:47
 */
class Address
{

    protected $options;

    public function __construct(&$data = array())
    {
        $this->options = &$data;
    }

    /**
     * @param string $value
     * @return \NetBricks\Place\Model\PlaceDocument
     */
    public function setName($value)
    {
        $this->options['name'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string)@$this->options['name'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Place\Model\PlaceDocument
     */
    public function setStreet($value)
    {
        $this->options['street'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return (string)@$this->options['street'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Place\Model\PlaceDocument
     */
    public function setCity($value)
    {
        $this->options['city'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return (string)@$this->options['city'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Place\Model\PlaceDocument
     */
    public function setPostcode($value)
    {
        $this->options['postcode'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return (string)@$this->options['postcode'];
    }

    /**
     * @param string $value
     * @return \NetCore\Utils\ArrayUtils\Address
     */
    public function setCountry($value)
    {
        $this->options['country'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return (string)@$this->options['country'];
    }

    public function __toString()
    {
        return join("\n", array_values(array(
            $this->getName(),
            $this->getCountry(),
            $this->getStreet(),
            $this->getPostcode() . ' ' . $this->getCity()
        )));
    }

    public function toArray()
    {
        return $this->options;
    }

}
