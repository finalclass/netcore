<?php
/**
 * Author: Sel <s@finalclass.net>
 * Date: 10.11.11
 * Time: 10:23
 */

namespace NetCore\Doctrine;

use \Doctrine\ORM\Configuration;

class DoctrineConfig extends Configuration
{
    private $namespaces;

    public function __construct()
    {
        parent::__construct();

        $this->namespaces = new DoctrineNamespaces();

        if (APPLICATION_ENV == "development") {
            $cache = new ArrayCache();
        } else {
            $cache = new ApcCache();
        }

        $this->setMetadataCacheImpl($cache);
        $this->setQueryCacheImpl($cache);

        //@TODO wywalić to na zewnątrz
        $this->setProxyDir(ROOT_PATH . '/lib/NetBricks/Proxies');
        $this->setProxyNamespace('NetBricks\Proxies');

        if (APPLICATION_ENV == "development") {
            $this->setAutoGenerateProxyClasses(true);
        } else {
            $this->setAutoGenerateProxyClasses(false);
        }
    }

    public function getNamespaces()
    {
        return $this->namespaces;
    }

    private function updateNamespaces()
    {
        $driverImpl = $this->newDefaultAnnotationDriver(
            array_values($this->namespaces->getAll())
        );

        $this->setMetadataDriverImpl($driverImpl);
        $this->setEntityNamespaces($this->namespaces->getAll());
    }
    
}
