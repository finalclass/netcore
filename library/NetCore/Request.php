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

use \NetCore\Configurable\OptionsAbstract;
use \NetCore\Configurable\DynamicObject\Reader;

/**
 * Author: Szymon Wygnański
 * Date: 06.09.11
 * Time: 18:00
 */
class Request extends Reader
{

    private $params = array();

    private $services = array();
    private $substitutions = array();

    protected $options = array();

    public function __construct(&$params = array())
    {
        parent::__construct($params);
    }

    /**
     * @param string $value
     * @return \NetCore\Request
     */
    public function setBaseUrl($value)
    {
        $this->options['base_url'] = $value;
        return $this;
    }

    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return empty($this->options['base_url']) ? $this->getBaseUrlFromRequest() : $this->options['base_url'];
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return string current url. Always ends with slash: "/"
     */
    public function getBaseUrlFromRequest()
    {
        $pageURL = (@$_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
        if ($_SERVER['SERVER_PORT'] != '80') {
            $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
        }
        else {
            $pageURL .= $_SERVER['SERVER_NAME'];
        }
        return rtrim($pageURL, '/') . '/';
    }

    /**
     * @return string current url. Always ends with '/'
     */
    public function getCurrentUrlFull()
    {
        return $this->getBaseUrlFromRequest() . ltrim($_SERVER['REQUEST_URI'], '/');
    }

    /**
     * @param $params
     * @return \NetCore\Request
     */
    public function setParams(&$params)
    {
        $this->setTarget($params);
        return $this;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->getMethod() == 'post';
    }

    public function getAllParams()
    {
        return $this->target;
    }

    public function getParam($paramName, $defaultValue = '')
    {
        return $this->$paramName->exists() ? $this->$paramName->getValue() : $defaultValue;
    }

    /**
     * @param string $value
     * @return \NetCore\Request
     */
    public function setUri($value)
    {
        $this->options['uri'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return empty($this->options['uri']) ? $_SERVER['REQUEST_URI'] : $this->options['uri'];
    }

    public function getHost()
    {
        return $_SERVER['SERVER_NAME'];
    }

    public function getUriExploded($separator = '/')
    {
        $uri = $this->getUri();
        $questionMarkPosition = strpos($uri, '?');
        if($questionMarkPosition !== false) {
            $uri = substr($uri, 0, $questionMarkPosition);
        }
        return array_values(array_filter(explode($separator, $uri)));
    }

}
