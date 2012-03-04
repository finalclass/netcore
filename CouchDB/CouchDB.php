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
use \NetCore\CouchDB\Config;
use \NetCore\Renderer;
use \NetCore\Configurable\DynamicObject\Writer;
use \NetCore\CouchDB\Exception\WrongRequest;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 28.02.12
 * @time: 14:44
 */
class CouchDB
{

    /** @var \Zend_Http_Client */
    private $request;

    /** @var \NetCore\CouchDB\Config */
    private $config;

    public function __construct(Config $config = null)
    {
        $this->request = new \Zend_Http_Client();
        $this->request->setHeaders('Content-Type', 'application/json');
        $this->config = $config ? $config : new Config();
    }

    /**
     * @param \NetCore\CouchDB\Config $value
     * @return \NetCore\CouchDB
     */
    public function setConfig(Config $value)
    {
        $this->config = $value;
        return $this;
    }

    /** @return \NetCore\CouchDB\Config */
    public function getConfig()
    {
        return $this->config;
    }

    private function getUrl()
    {
        $cfg = $this->config;
        return 'http://' . $cfg->getUser() . ':' . $cfg->getPassword()
                . '@' . $cfg->getHost() . ':' . $cfg->getPort()
                . '/' . $cfg->getDatabase();
    }

    public function request($url, $type = \Zend_Http_Client::GET, $document = null)
    {
        return json_decode($this->request->setUri($url)
            ->setRawData($document ? json_encode($document) : '')
            ->request($type)
            ->getBody(), true);
    }

    public function get($id)
    {
        return $this->request($this->getUrl() . '/' . $id, \Zend_Http_Client::GET);
    }

    public function post(array $document)
    {
        return $this->request($this->getUrl(), \Zend_Http_Client::POST, $document);
    }

    public function put($id, $rev, array $document)
    {
        $document['_rev'] = $rev;
        return $this->request($this->getUrl() . '/' . $id, \Zend_Http_Client::PUT, $document);
    }

    /**
     * Does put or post depending on existance of $document['_id'] and $document['_rev'] property.
     * After saving set's the $document['_id'] and $document['_rev'] properties
     *
     * @param array $document
     * @return array saved document with _id and _rev set
     */
    public function save(array $document)
    {
        if(empty($document['_id']) || empty($document['_rev'])) {
            $response = $this->post($document);
        } else {
            $response = $this->put($document['_id'], $document['_rev'], $document);
        }

        $document['_id'] = $response['id'];
        $document['_rev'] = $response['rev'];
        return $document;
    }

    public function delete($id, $rev)
    {
        return $this->request($this->getUrl() . '/' . $id . '?rev=' . $rev, \Zend_Http_Client::DELETE);
    }

    public function initView(array $document, $designDocumentName = '_design/common', $viewName = null)
    {
        if(empty($document)) {
            throw new \NetCore\CouchDB\Exception\InitViewError('document should have at least one key');
        }
        $conditionParts = array();
        $emitetValues = array(
            '_id' => '_id: doc._id',
            '_rev' => '_rev: doc._rev'
        );
        foreach($document as $propName => $value) {
            $conditionParts[] = 'doc.' . $propName;
            $emitetValues[$propName] = $propName . ': doc.' . $propName;
        }

        $view =
        'function(doc) {
            if(' . join(' && ', $conditionParts) .') {
                emit(doc._id, { ' . join(', ', $emitetValues) . '});
            }
        }';

        $rawExistingDoc= $this->get($designDocumentName);
        $existingDoc = new Writer($rawExistingDoc);

        if(@$existingDoc->error == 'not_found') {
            return $this->put($designDocumentName, '', array(
                'views' => array(
                    $viewName => array(
                        'map' => $view
                    ))));
        }

        if($existingDoc->error->exists()) {
            throw new \NetCore\CouchDB\Exception\DesignDocumentError((string)$existingDoc->error);
        }

        $existingDoc->views->$viewName->map = $view;

        return $this->put($designDocumentName, (string)@$existingDoc->_rev->getString(), $existingDoc->getArray());
    }


}
