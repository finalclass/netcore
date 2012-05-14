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
use \NetCore\Configurable\OptionsAbstract;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 14.05.12
 * @time: 11:13
 */
class Query extends OptionsAbstract
{

    protected $options = array(
        'key' => null,
        'keys' => null,
        'startkey' => null,
        'endkey' => null,
        'limit' => null,
        'descending' => null,
        'skip' => null,
        'group' => null,
        'include_docs' => null
    );

    protected $viewName = 'no_view_name_specified';

    static public function factory($options = array())
    {
        return new Query($options);
    }

    public function __construct($options = array())
    {
        parent::__construct($options);
    }

    public function __toString()
    {
        $key = $this->getKey();
        $keys = $this->getKeys();
        $startKey = $this->getStartKey();
        $endKey = $this->getEndKey();
        $limit = $this->getlimit();
        $skip = $this->getSkip();
        $group = $this->getGroup();
        $includeDocs = $this->getIncludeDocs();

        $params = array();
        if ($key !== null) {
            $params['key'] = json_encode($key);
        }
        if ($keys !== null) {
            $params['keys'] = json_encode($keys);
        }
        if ($startKey !== null) {
            $params['startkey'] = json_encode($startKey);
        }
        if ($endKey !== null) {
            $params['endkey'] = json_encode($endKey);
        }
        if ($limit !== null) {
            $params['limit'] = $limit;
        }
        if ($skip !== null) {
            $params['skip'] = $skip;
        }
        if ($group !== null) {
            $params['group'] = $group ? 'true' : 'false';
        }
        if ($includeDocs !== null) {
            $params['include_docs'] = $includeDocs ? 'true' : 'false';
        }

        return $this->getViewName() . '?' . join('&', $params);
    }


    /**
     * @param string $value
     * @return \NetCore\CouchDB\Query
     */
    public function setViewName($value)
    {
        $this->viewName = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return (string)@$this->viewName;
    }


    /**
     * @param boolean $value
     * @return \NetCore\CouchDB\Query
     */
    public function setIncludeDocs($value)
    {
        $this->options['include_docs'] = (boolean)$value;
        return $this;
    }

    /**
     * @return
     */
    public function getIncludeDocs()
    {
        return @$this->options['include_docs'];
    }

    /**
     * @param boolean $value
     * @return \NetCore\CouchDB\Query
     */
    public function setGroup($value)
    {
        $this->options['group'] = (boolean)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getGroup()
    {
        return @$this->options['group'];
    }

    /**
     * @param int $value
     * @return \NetCore\CouchDB\Query
     */
    public function setSkip($value)
    {
        $this->options['skip'] = (int)$value;
        return $this;
    }

    /**
     * @return int
     */
    public function getSkip()
    {
        return @$this->options['skip'];
    }

    /**
     * @param boolean $value
     * @return \NetCore\CouchDB\Query
     */
    public function setDescending($value)
    {
        $this->options['descending'] = (boolean)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getDescending()
    {
        return @$this->options['descending'];
    }

    /**
     * @param int $value
     * @return \NetCore\CouchDB\Query
     */
    public function setLimit($value)
    {
        $this->options['limit'] = (int)$value;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return @$this->options['limit'];
    }


    /**
     * @param mixed $value
     * @return \NetCore\CouchDB\Query
     */
    public function setEndKey($value)
    {
        $this->options['endkey'] = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndKey()
    {
        return @$this->options['endkey'];
    }

    /**
     * @param mixed $value
     * @return \NetCore\CouchDB\Query
     */
    public function setStartKey($value)
    {
        $this->options['startkey'] = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartKey()
    {
        return @$this->options['startkey'];
    }

    /**
     * @param array $value
     * @return \NetCore\CouchDB\Query
     */
    public function setKeys($value)
    {
        $this->options['keys'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return @$this->options['keys'];
    }

    /**
     * @param string $value
     * @return \NetCore\CouchDB\Query
     */
    public function setKey($value)
    {
        $this->options['key'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return @$this->options['key'];
    }

}
