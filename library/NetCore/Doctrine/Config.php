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

namespace NetCore\Doctrine;

use \NetCore\Doctrine\Config\CouchDB;
use \NetCore\DependencyInjection\ConfigurableContainer;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 28.02.12
 * @time: 10:01
 *
 * @property \NetCore\Doctrine\Config\CouchDB $couchdb
 */
class Config extends ConfigurableContainer
{

    protected $options = array();

    private $couchdb;

    /**
     * @return \NetCore\Doctrine\Config\CouchDB
     */
    public function getCouchdb()
    {
        if(!$this->couchdb) {
            $this->couchdb = new CouchDB((array)@$this->options['couchdb']);
        }
        return $this->couchdb;
    }
}
