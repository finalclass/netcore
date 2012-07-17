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

namespace NetCore;
use \NetCore\Configurable\StaticConfigurator;


class Sode
{

    /**
     * @var \NetCore\Sode\Config
     */
    private $config;

    /**
     * @var \NetCore\Sode\Response
     */
    private $lastResponse;

    /**
     * @static
     * @param array $options
     * @return \NetCore\Sode
     */
    static public function Factory($options = array())
    {
        return new Sode($options);
    }

    /**
     * @param array $options
     */
    public function __construct($options = array())
    {
        $this->config = new \NetCore\Sode\Config($options);
    }

    /**
     * @param array $cfg
     * @return \NetCore\Sode
     */
    public function setConfig($cfg = array())
    {
        $this->config->setConfig($cfg);
        return $this;
    }

    /**
     * @return \Zend_Http_Client
     */
    private function getHttpClient()
    {
        $client = new \Zend_Http_Client();

        $client->setConfig(array('maxredirects' => 0, 'timeout' => 30));
        $client->setMethod(\Zend_Http_Client::POST);

        $client->setParameterPost(
            array(
                 'login' => $this->config->getLogin(),
                 'password' => $this->config->getPassword(),
                 'companyid' => $this->config->getCompanyId(),
            ));

        return $client;
    }

    /**
     * @param \NetCore\Sode\Client $client
     * @return \NetCore\Sode
     */
    public function importClient(\NetCore\Sode\Client $client)
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $clientNode = $doc->importNode($client->toDOMElement(), true);
        $doc->appendChild($doc->createElement('root'))
                ->appendChild($clientNode);

        $httpClient = $this->getHttpClient();
        $httpClient->setUri($this->config->getSodeUrl() . '/remote/importclients/');
        $httpClient->setParameterPost('xml', $doc->saveXML());
        $response = $httpClient->request();

        $this->lastResponse = new \NetCore\Sode\Response($response->getBody());
        return $this;
    }

    /**
     *
     * @param \NetCore\Sode\Document $document
     * @return \NetCore\Sode
     */
    public function importDocument(\NetCore\Sode\Document $document)
    {
        $httpClient = $this->getHttpClient();
        $httpClient->setUri($this->config->getSodeUrl() . '/remote/extendimport/');
        $httpClient->setParameterPost('xml', $document->toDOMDocument()->saveXML());
        $body = $httpClient->request()->getBody();
        $this->lastResponse = new \NetCore\Sode\Response($body);

        return $this;
    }

    /**
     * @return \NetCore\Sode\Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @param $hash
     * @param int $received
     * @return \NetCore\Sode
     */
    public function getDocument($hash, $received = 0)
    {
        $httpClient = $this->getHttpClient();
        $httpClient->setUri($this->config->getSodeUrl() . '/remote/getdocument');
        $httpClient->setParameterPost('key', $hash);
        $httpClient->setParameterPost('received', $received);

        $this->lastResponse = new \NetCore\Sode\Response($httpClient->request()->getBody());
        return $this;
    }

    /**
     * @param $hash
     * @return \NetCore\Sode
     */
    public function checkStatus($hash)
    {
        $httpClient = $this->getHttpClient();
        $httpClient->setUri($this->config->getSodeUrl() . '/remote/checkstatus');
        $httpClient->setParameterPost('key', $hash);
        $this->lastResponse = new \NetCore\Sode\Response($httpClient->request()->getBody());
        return $this;
    }

}
