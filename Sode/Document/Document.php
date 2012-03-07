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

namespace NetCore\Sode;
use \NetCore\Configurable\StaticConfigurator;

class Document
{

    /**
     * @var array
     */
    private $options = array();

    /**
     * @var \NetCore\Sode\Document\Element[]
     */
    private $elements = array();

    /**
     * @var \NetCore\Sode\Document\Properties
     */
    private $properties;

    /**
     * @var \NetCore\Sode\Client;
     */
    private $client;

    static public function Factory($options = array())
    {
        return new \NetCore\Sode\Document($options);
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
     * @return void
     */
    public function setOptions($options = array())
    {
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        }
        StaticConfigurator::SetOptions($this, $options);
    }

    /**
     * @return \DOMDocument
     */
    public function toDOMDocument()
    {
        $implementation = new \DOMImplementation();
        $dtd = $implementation->createDocumentType('root', null, 'https://www.sode.pl/sode.dtd');
        $dom = $implementation->createDocument('', '', $dtd);
        $root = $dom->createElement('root');
        $properties = $dom->importNode($this->getProperties()->toDOMElement(), true);
        $client = $dom->importNode($this->getClient()->toDOMElementWithAttributes(), true);
        $document = $dom->createElement('document');
        $document->setAttribute('type', $this->getType());
        $document->setAttribute('label', $this->getLabel());
        $document->setAttribute('label_name', $this->getLabelName());
        $document->setAttribute('notify', $this->getNotify());
        $document->setAttribute('paid', $this->getPaid() ? 1 : 0);

        $root->appendChild($document);
        $document->appendChild($properties);
        $document->appendChild($client);

        $elements = $dom->createElement('elements');
        foreach ($this->elements as $element) {
            $elements->appendChild($dom->importNode($element->toDOMElement(), true));
        }

        if($this->getAutoTotalEntry()) {
            $elements->appendChild($dom->importNode($this->getTotalElement()->toDOMElement(), true));
        }

        $document->appendChild($elements);
        $dom->formatOutput = true;
        $dom->appendChild($root);
        return $dom;
    }

    /**
     * @return \NetCore\Sode\Document\Element
     */
    public function getTotalElement()
    {
        $netto = 0;
        $brutto = 0;
        $vat = 0;
        foreach($this->elements as $element) {
            if($element->getType() != 'entry') {
                continue;
            }
            $netto += $element->getValueNetto();
            $brutto += $element->getValueBrutto();
            $vat += $element->getValueVat();
        }
        return  \NetCore\Sode\Document\Element::Factory()
                ->setType('total')
                ->setName('Razem')
                ->setValueNetto($netto)
                ->setValueBrutto($brutto)
                ->setValueVat($vat);
    }

    /**
     * @param \NetCore\Sode\Client $client
     * @return \NetCore\Sode\Document
     */
    public function setClient(\NetCore\Sode\Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return \NetCore\Sode\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param \NetCore\Sode\Document\Element $element
     * @return \NetCore\Sode\Document
     */
    public function addElement(\NetCore\Sode\Document\Element $element)
    {
        $this->elements[] = $element;
        return $this;
    }

    /**
     * @param $type string invoice, einvoice, invoice_prforma or bill
     * @return \NetCore\Sode\Document
     */
    public function setType($type)
    {
        switch ($type) {
            case 'invoice':
            case 'einvoice':
            case 'invoice_proforma':
            case 'bill':
                $this->options['type'] = $type;
                break;
            default:
                throw new \InvalidArgumentException('Wrong document type: ' . $type . ' accepted types are: invoice, einvoice, invoice_proforma, bill');
                break;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return isset($this->options['type']) ? $this->options['type'] : 'bill';
    }

    /**
     *
     * @param bool $value
     * @return \NetCore\Sode\Document
     */
    public function setAutoTotalEntry($value)
    {
        $this->options['auto_total_entry'] = (bool)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getAutoTotalEntry()
    {
        return isset($this->options['auto_total_entry']) ? $this->options['auto_total_entry'] : false;
    }

    /**
     * @param string $label
     * @return \NetCore\Sode\Document
     */
    public function setLabel($label = '_AUTO_')
    {
        $this->options['label'] = $label;
        return $this;
    }

    /**
     * @return string default _AUTO_
     */
    public function getLabel()
    {
        return isset($this->options['label']) ? $this->options['label'] : '_AUTO_';
    }

    /**
     * @param string $labelName
     * @return \NetCore\Sode\Document
     */
    public function setLabelName($labelName)
    {
        $this->options['label_name'] = $labelName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelName()
    {
        return isset($this->options['label_name']) ? $this->options['label_name'] : '_AUTO_';
    }

    /**
     * @param string $notify 'true' or ''
     * @return \NetCore\Sode\Document
     */
    public function setNotify($notify)
    {
        $this->options['notify'] = $notify ? 'true' : '';
        return $this;
    }

    public function getNotify()
    {
        return isset($this->options['notify']) ? $this->options['notify'] : '';
    }

    /**
     * @param \NetCore\Sode\Document\Properties $properties
     * @return \NetCore\Sode\Document
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * @return \NetCore\Sode\Document\Properties
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     *
     * @param bool $value
     * @return \NetCore\Sode\Document
     */
    public function setPaid($value)
    {
        $this->options['paid'] = (bool)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaid()
    {
        return isset($this->options['paid']) ? $this->options['paid'] : false;
    }

}
