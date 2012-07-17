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

namespace NetCore\CouchDB;
use \NetCore\DependencyInjection\ConfigurableContainer;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 28.02.12
 * @time: 15:34
 */
class Config extends ConfigurableContainer
{
    protected $options = array(
        'database' => '',
        'host' => '',
        'user' => '',
        'password' => '',
        'document_paths' => array(),
        'proxy_dir' => '',
        'port' => 5984
    );

    /**
     * @param string $value
     * @return \NetCore\CouchDB\Config
     */
    public function setPort($value)
    {
        $this->options['port'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return empty($this->options['port']) ? 5984 : $this->options['port'];
    }

    /**
     * @param string $value
     * @return \NetCore\CouchDB\Config
     */
    public function setProxyDir($value)
    {
        $this->options['proxy_dir'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getProxyDir()
    {
        return empty($this->options['proxy_dir']) ? '' : $this->options['proxy_dir'];
    }

    /**
     * @param $path
     * @return \NetCore\CouchDB\Config
     */
    public function addDocumentPath($path)
    {
        $this->options['document_paths'][] = $path;
        return $this;
    }

    /**
     * @param string $value
     * @return \NetCore\CouchDB\Config
     */
    public function setDocumentPaths($value)
    {
        $this->options['document_paths'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentPaths()
    {
        return empty($this->options['document_paths']) ? '' : $this->options['document_paths'];
    }


    /**
     * @param string $value
     * @return \NetCore\CouchDB\Config
     */
    public function setHost($value)
    {
        $this->options['host'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return empty($this->options['host']) ? '' : $this->options['host'];
    }

    /**
     * @param string $value
     * @return \NetCore\CouchDB\Config
     */
    public function setPassword($value)
    {
        $this->options['password'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return empty($this->options['password']) ? '' : $this->options['password'];
    }

    /**
     * @param string $value
     * @return \NetCore\CouchDB\Config
     */
    public function setUser($value)
    {
        $this->options['user'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return empty($this->options['user']) ? '' : $this->options['user'];
    }

    /**
     * @param string $value
     * @return \NetCore\CouchDB\Config
     */
    public function setDatabase($value)
    {
        $this->options['database'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return empty($this->options['database']) ? '' : $this->options['database'];
    }
}
