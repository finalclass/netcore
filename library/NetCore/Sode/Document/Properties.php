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


class Properties
{

    /**
     * @var array
     */
    private $options = array();

    /**
     * @static
     * @param array $options
     * @return \NetCore\Sode\Document\Properties
     */
    static public function Factory($options = array())
    {
        return new \NetCore\Sode\Document\Properties($options);
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
        if($options instanceof \Zend_Config) {
            $options = $options->toArray();
        }
        StaticConfigurator::SetOptions($this, $options);
    }

    /**
     * @return \DOMElement
     */
    public function toDOMElement()
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $properties = $dom->createElement('properties');

        $properties->appendChild($dom->createElement('document_issuer', $this->getDocumentIssuer()));
        $properties->appendChild($dom->createElement('document_created', $this->getDocumentCreated()));
        $properties->appendChild($dom->createElement('document_place', $this->getDocumentPlace()));
        $properties->appendChild($dom->createElement('payment', $this->getPayment()));
        $properties->appendChild($dom->createElement('invoice_sold', $this->getInvoiceSold()));
        $properties->appendChild($dom->createElement('comment', $this->getComment()));
        $properties->appendChild($dom->createElement('przelewy24_id', $this->getPrzelewy24Id()));
        $properties->appendChild($dom->createElement('return_url', $this->getReturnUrl()));
        $properties->appendChild($dom->createElement('ban_number', $this->getBanNumber()));
        $properties->appendChild($dom->createElement('ban_bankname', $this->getBanBankname()));

        
        return $properties;
    }

    /**
     * @param string $documentIsuser
     * @return \NetCore\Sode\Document\Properties
     */
    public function setDocumentIssuer($documentIsuser)
    {
        $this->options['document_issuer'] = $documentIsuser;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentIssuer()
    {
        return isset($this->options['document_issuer']) ? $this->options['document_issuer'] : '';
    }

    /**
     * @param string $documentCreated date in string format YYYY-mm-dd
     * @return \NetCore\Sode\Document\Properties
     */
    public function setDocumentCreated($documentCreated)
    {
        $this->options['document_created'] = $documentCreated;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentCreated()
    {
        return isset($this->options['document_created']) ? $this->options['document_created'] : date('Y-m-d');
    }

    /**
     * @param string $documentPlace
     * @return \NetCore\Sode\Document\Properties
     */
    public function setDocumentPlace($documentPlace)
    {
        $this->options['document_place'] = $documentPlace;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentPlace()
    {
        return isset($this->options['document_place']) ? $this->options['document_place'] : '';
    }

    /**
     * @param string $payment
     * @return \NetCore\Sode\Document\Properties
     */
    public function setPayment($payment)
    {
        $this->options['payment'] = $payment;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayment()
    {
        return isset($this->options['payment']) ? $this->options['payment'] : '';
    }

    /**
     * @param string $paymentDate date in string format YYYY-mm-dd
     * @return \NetCore\Sode\Document\Properties
     */
    public function setPaymentDate($paymentDate)
    {
        $this->options['payment_date'] = $paymentDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentDate()
    {
        return isset($this->options['payment_date']) ? $this->options['payment_date'] : date('Y-m-d');
    }

    /**
     * @param string $invoiceSold
     * @return \NetCore\Sode\Document\Properties
     */
    public function setInvoiceSold($invoiceSold)
    {
        $this->options['invoice_sold'] = $invoiceSold;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceSold()
    {
        return isset($this->options['invoice_sold']) ? $this->options['invoice_sold'] : '';
    }

    /**
     * @param string $comment
     * @return \NetCore\Sode\Document\Properties
     */
    public function setComment($comment)
    {
        $this->options['comment'] = $comment;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return isset($this->options['commnet']) ? $this->options['comment'] : '';
    }

    /**
     * @param string $przelewy24Id
     * @return \NetCore\Sode\Document\Properties
     */
    public function setPrzelwy24Id($przelewy24Id)
    {
        $this->options['przelewy24_id'] = $przelewy24Id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrzelewy24Id()
    {
        return isset($this->options['przelewy24_id']) ? $this->options['przelewy24_id'] : '';
    }

    /**
     * @param string $returnUrl
     * @return \NetCore\Sode\Document\Properties
     */
    public function setReturnUrl($returnUrl)
    {
        $this->options['return_url'] = $returnUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        return isset($this->options['return_url']) ? $this->options['return_url'] : '';
    }

    /**
     * @param $banNumber
     * @return \NetCore\Sode\Document\Properties
     */
    public function setBanNumber($banNumber)
    {
        $this->options['ban_number'] = $banNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getBanNumber()
    {
        return isset($this->options['ban_number']) ? $this->options['ban_number'] : '';
    }

    /**
     * @param $banBankname
     * @return \NetCore\Sode\Document\Properties
     */
    public function setBanBankname($banBankname)
    {
        $this->options['ban_bankname'] = $banBankname;
        return $this;
    }

    /**
     * @return string
     */
    public function getBanBankname()
    {
        return isset($this->options['ban_bankname']) ? $this->options['ban_bankname'] : '';
    }


}
