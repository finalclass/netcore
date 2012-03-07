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

class Response
{

    /**
     * @var \NetCore\Sode\Response\Document
     */
    private $document;

    /**
     * @var \NetCore\Sode\Response\Client
     */
    private $client;

    private $key;

    private $status;

    private $error;

    private $name;

    private $pdf;

    public function __construct($sodeXmlStringResponse)
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML($sodeXmlStringResponse);

        $keyNodes = $doc->getElementsByTagName('key');
        $statusNodes = $doc->getElementsByTagName('status');
        $errorNodes = $doc->getElementsByTagName('error');
        $nameNodes = $doc->getElementsByTagName('name');
        $pdfNOdes = $doc->getElementsByTagName('pdf');
        $labelNodes = $doc->getElementsByTagName('label');
        $nipNodes = $doc->getElementsByTagName('nip');
        $externalIdNodes = $doc->getElementsByTagName('external_id');
        $idNodes = $doc->getElementsByTagName('id');


        $this->key = ($keyNodes->length > 0) ? $keyNodes->item(0)->textContent : null;
        $this->status = ($statusNodes->length > 0) ? $statusNodes->item(0)->textContent : null;
        $this->error = ($errorNodes->length > 0) ? $errorNodes->item(0)->textContent : null;
        $this->name = ($nameNodes->length > 0) ? $nameNodes->item(0)->textContent : '';
        $this->pdf = ($pdfNOdes->length > 0) ? $pdfNOdes->item(0)->textContent : '';

        $this->document = new \NetCore\Sode\Response\Document(
            array(
                'label' => ($labelNodes->length > 0) ? $labelNodes->item(0)->textContent : '',
                'key' => ($keyNodes->length > 0) ? $keyNodes->item(0)->textContent : '',
                'status' => ($statusNodes->length > 0) ? $statusNodes->item(0)->textContent : '',
                'error' => ($errorNodes->length > 0) ? $errorNodes->item(0)->textContent : ''
            )
        );

        $this->client = new \NetCore\Sode\Response\Client(
            array(
                'name' => ($nameNodes->length > 0) ? $nameNodes->item(0)->textContent : '',
                'nip' => ($nipNodes->length > 0) ? $nipNodes->item(0)->textContent : '',
                'external_id' => ($externalIdNodes->length > 0) ? $externalIdNodes->item(0)->textContent : '',
                'id' => ($idNodes->length > 0) ? $idNodes->item(0)->textContent : '',
                'status' => ($statusNodes->length > 0) ? $statusNodes->item(0)->textContent : '',
                'error' => ($errorNodes->length > 0) ? $errorNodes->item(0)->textContent : ''
            )
        );
    }

    /**
     * @return \NetCore\Sode\Response\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return \NetCore\Sode\Response\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPdf()
    {
        return $this->pdf;
    }


}
