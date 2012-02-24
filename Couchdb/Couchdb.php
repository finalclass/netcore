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

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.02.12
 * @time: 12:56
 */
class Couchdb
{

    private $host;
    private $port;
    private $user;
    private $password;
    private $database;

    private $request;

    public function __construct($options = array())
    {
        $this->host = isset($options['host']) ? (string)$options['host'] : 'localhost';
        $this->port = isset($options['port']) ? (int)$options['port'] : 5984;
        $this->user = isset($options['user']) ? (string)($options['user']) : '';
        $this->password = isset($options['password']) ? (string)$options['password'] : '';
        $this->database = isset($options['database']) ? (string)$options['database'] : '';

        $this->request = new \HttpRequest();
    }

    public function getUrl()
    {
        return 'http://'
                . $this->user . ':' . $this->password
                . '@' . $this->host . ':' . $this->port
                . '/' . $this->database;
    }

    public function get($id)
    {
        $this->request->setUrl($this->getUrl() . '/' . $id);
        $this->request->setMethod(\HttpRequest::METH_GET);
        return json_decode($this->request->send()->getBody(), true);
    }



}
