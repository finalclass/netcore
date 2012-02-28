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

    public function get($id)
    {
        $this->request->setUri($this->getUrl() . '/' . $id);
        return json_decode($this->request->request(\Zend_Http_Client::GET)->getBody());
    }


}
