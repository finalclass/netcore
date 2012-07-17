<?php

namespace NetCore\Doctrine;

use \NetCore\Configurable\OptionsAbstract;

/**
 * Author: Szymon Wygnański
 * Date: 12.09.11
 * Time: 17:42
 */
class Helper extends OptionsAbstract
{
    public function toArray($entity)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em;
         */
        $em = $this->getEm();
        $class = $em->getClassMetadata(get_class($entity));
        $out = array();
        foreach($class->fieldMappings as $name=>$field) {
            $out[$name] = $class->reflFields[$name]->getValue($entity);
        }
        return $out;
    }

    /**
     * @param $entity
     * @param $values
     * @return Helper
     */
    public function fromArray($entity, $values)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em;
         */
        $em = $this->getEm();
        $class = $em->getClassMetadata(get_class($entity));
        foreach($values as $key=>$value) {
            if (isset($class->fieldMappings[$key])) {
                $class->reflFields[$key]->setValue($entity, $value);
            }
        }
        return $this;
    }

    /**
     * @param $value
     * @return Helper
     */
    public function setEm($value)
    {
        $this->options['em'] = $value;
        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return isset($this->options['em']) ? $this->options['em'] : null;
    }

}
