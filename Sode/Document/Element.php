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

namespace NetCore\Sode\Document;
use \NetCore\Configurable\StaticConfigurator;


class Element
{

    /**
     * @var array
     */
    private $options = array();

    static public function Factory($options = array())
    {
        return new \NetCore\Sode\Document\Element($options);
    }

    /**
     * @param array $options
     */
    public function __construct($options = array())
    {
        $this->setOptions($options);
    }

    /**
     * @param array $options
     * @return \NetCore\Sode\Document\Element
     */
    public function setOptions($options = array())
    {
        StaticConfigurator::SetOptions($this, $options);
        return $this;
    }

    /**
     * @return \DOMElement
     */
    public function toDOMElement()
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $element = $dom->createElement('document_element');
        $element->setAttribute('type', $this->getType());
        $element->setAttribute('name', $this->getName());

        if($this->getType() == 'entry' || $this->getType() == 'sum') {
            $element->setAttribute('tax', $this->getTax() . '%');
        }

        if($this->getType() == 'entry') {
            if($this->getUnit()) {
                $element->setAttribute('unit', $this->getUnit());
            }
            $element->setAttribute('count', $this->getCount());
            $element->setAttribute('price_netto', $this->getPriceNetto());
            $element->setAttribute('price_brutto', $this->getPriceBrutto());
            $element->setAttribute('price_vat', $this->getPriceVat());
        }
        
        $element->setAttribute('value_netto', $this->getValueNetto());
        $element->setAttribute('value_brutto', $this->getValueBrutto());
        $element->setAttribute('value_vat', $this->getValueVat());
        return $element;
    }


    /**
     * @param string $type
     * @return \NetCore\Sode\Document\Element
     */
    public function setType($type)
    {
        switch($type) {
            case 'entry':
            case 'sum':
            case 'total':
                $this->options['type'] = $type;
                break;
            default:
                $this->options['type'] = 'entry';
                break;
        }
        
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return isset($this->options['type']) ? $this->options['type'] : 'entry';
    }

    /**
     * @param string $name
     * @return \NetCore\Sode\Document\Element
     */
    public function setName($name)
    {
        $this->options['name'] = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return isset($this->options['name']) ? $this->options['name'] : '';
    }

    /**
     * @param string $unit
     * @return \NetCore\Sode\Document\Element
     */
    public function setUnit($unit)
    {
        $this->options['unit'] = $unit;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return isset($this->options['unit']) ? $this->options['unit'] : '';
    }

    /**
     * @param float $count
     * @return \NetCore\Sode\Document\Element
     */
    public function setCount($count)
    {
        $this->options['count'] = intval($count);
        return $this;
    }

    /**
     * @return float
     */
    public function getCount()
    {
        return isset($this->options['count']) ? $this->options['count'] : 1;
    }

    /**
     * @param float $tax
     * @return \NetCore\Sode\Document\Element
     */
    public function setTax($tax)
    {
        $this->options['tax'] = floatval($tax);
        return $this;
    }

    /**
     * @return float
     */
    public function getTax()
    {
        return isset($this->options['tax']) ? $this->options['tax'] : 23;
    }

    /**
     * @param float $priceNetto
     * @return \NetCore\Sode\Document\Element
     */
    public function setPriceNetto($priceNetto)
    {
        $this->options['price_netto'] = floatval($priceNetto);
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceNetto()
    {
        return isset($this->options['price_netto']) ? $this->options['price_netto'] : 0;
    }

    /**
     * @param float $priceBrutto
     * @return \NetCore\Sode\Document\Element
     */
    public function setPriceBrutto($priceBrutto)
    {
        $this->options['price_brutto'] = floatval($priceBrutto);
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceBrutto()
    {
        return isset($this->options['price_brutto']) ? $this->options['price_brutto'] : 0;
    }

    /**
     * @param float $priceVat
     * @return \NetCore\Sode\Document\Element
     */
    public function setPriceVat($priceVat)
    {
        $this->options['price_vat'] = floatval($priceVat);
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceVat()
    {
        return isset($this->options['price_vat']) ? $this->options['price_vat'] : 0;
    }

    /**
     * @param float $valueNetto
     * @return \NetCore\Sode\Document\Element
     */
    public function setValueNetto($valueNetto)
    {
        $this->options['value_netto'] = floatval($valueNetto);
        return $this;
    }

    /**
     * @return float
     */
    public function getValueNetto()
    {
        return isset($this->options['value_netto']) ? $this->options['value_netto'] : 0;
    }

    /**
     * @param float $valueBrutto
     * @return \NetCore\Sode\Document\Element
     */
    public function setValueBrutto($valueBrutto)
    {
        $this->options['value_brutto'] = floatval($valueBrutto);
        return $this;
    }

    /**
     * @return float
     */
    public function getValueBrutto()
    {
        return isset($this->options['value_brutto']) ? $this->options['value_brutto'] : 0;
    }

    /**
     * @param float $valueVat
     * @return \NetCore\Sode\Document\Element
     */
    public function setValueVat($valueVat)
    {
        $this->options['value_vat'] = floatval($valueVat);
        return $this;
    }

    /**
     * @return float
     */
    public function getValueVat()
    {
        return isset($this->options['value_vat']) ? $this->options['value_vat'] : 0;
    }

}
