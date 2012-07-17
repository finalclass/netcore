<?php
/**
 * Author: Sel <s@finalclass.net>
 * Date: 10.11.11
 * Time: 10:34
 */

namespace NetCore\Doctrine;

use \NetCore\Configurable\OptionsAbstract;

class DoctrineNamespaces extends OptionsAbstract
{
    private $namespaces = array();


    public function add($namespace, $path)
    {
        $this->namespaces[$namespace] = $path;
    }

    public function getAll()
    {
        return $this->namespaces;
    }
    
    public function getPathByNamespace($namespace)
    {
        return isset($this->namespaces[$namespace]) ? $this->namespaces[$namespace] : '';
    }
}
