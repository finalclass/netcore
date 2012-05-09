<?php

namespace NetCore;

use \NetCore\Configurable\OptionsAbstract;
use \NetCore\Factory\Exception\InvalidSubFactory;
use \NetCore\Factory\Exception\NotAllowed;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 25.11.11
 * @time: 09:18
 */
class Factory extends OptionsAbstract
{

    private $createdSubItems = array();

    /**
     * $options => array(
            'namespace' => 'NetCore\Component',
     *      'inherited' => array('skin_path' => 'path/to/skins'),
            'allowed' => array(),
            'tag' => array(
                'namespace' => 'NetCore\Component',
                'allowed' => array('guest'),
                'tag_name' => 'span'
            ),
     *      'form' => array(
     *          'namespace' => 'NetCore\Component\Form',
     *          'allowed' => array('admin')
     *          'textInput' => array(
     *             'namespace' => 'NetCore\Component\Form\TextInput'
     *             'allowed' => array('moderator')
     *             'name' => 'default_input_name'
     *          )
        );
     *
     * @param array $options
     */
    public function __construct($options = array())
    {
        if(is_string($options)) {
            $options = array('namespace' => $options);
        }
        $this->options = $options; //Important! to store values for children
        parent::__construct($options);
    }

    /**
     * @param array $value
     * @return \NetCore\Factory
     */
    public function setAllowed($value = array())
    {
        if(is_string($value)) {
            $value = array($value);
        }
        $this->options['allowed'] = array_filter($value);
        return $this;
    }
    
    /**
     * @return array
     */
    public function getAllowed()
    {
        $allowed = empty($this->options['allowed']) ? array() : $this->options['allowed'];
        return array_merge($allowed, $this->getInheritedAllowed());
    }

   /**
    * @param array $value
    * @return Factory
    */
    public function setRoles(array $value = array())
    {
        $this->options['roles'] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return empty($this->options['roles']) ? array() : $this->options['roles'];
    }

    /**
     * @param $value
     * @return Factory
     */
    public function setNamespace($value)
    {
        $this->options['namespace'] = $value;
        return $this;
    }

    /**
     * @param array $value
     * @return \NetCore\Factory
     */
    public function setInherited($value)
    {
        $this->options['inherited'] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getInherited()
    {
        return empty($this->options['inherited']) ? array() : $this->options['inherited'];
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return empty($this->options['namespace']) ? '' : $this->options['namespace'];
    }

    /**
     * @param $name
     * @return \NetCore\Factory
     */
    public function __get($name)
    {
        if(!isset($this->createdSubItems[$name])) {

            $componentOptions = isset($this->options[$name])
                    ? $this->options[$name] : array();

            $componentOptions['namespace'] = isset($componentOptions['namespace'])
                    ? $componentOptions['namespace'] : $this->getNamespace() . '\\' . ucfirst($name);

            $componentOptions['allowed'] = empty($componentOptions['allowed'])
                    ? $this->getAllowed() : $componentOptions['allowed'];

            $componentOptions['inherited_allowed'] = empty($componentOptions['inherited_allowed'])
                ? $this->getInheritedAllowed()
                : array_unique(array_merge($componentOptions['inherited_allowed'], $this->getInheritedAllowed()));

            $componentOptions['roles'] = empty($componentOptions['roles'])
                    ? $this->getRoles() : $componentOptions['roles'];

            $componentOptions['inherited'] = $this->getInherited();

            $this->createdSubItems[$name] = new Factory($componentOptions);
        }
        return $this->createdSubItems[$name];
    }

    /**
     * @param array $value
     * @return \NetCore\Factory
     */
    public function setInheritedAllowed($value)
    {
        $this->options['inherited_allowed'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getInheritedAllowed()
    {
        return (array)@$this->options['inherited_allowed'];
    }
    
    public function __call($name, $arguments = array())
    {
        /**
         * @var \Closure $item
         */
        $item = $this->$name;
        return $item($arguments);
    }

    /**
     *
     * @param string $name
     * @param \NetCore\Factory $factory
     * @throws Factory\Exception\InvalidSubFactory
     * @return void
     */
    public function __set($name, $factory)
    {
        if( !($factory instanceof Factory) ) {
            throw new InvalidSubFactory('You can only add Factory items to Factory');
        }

        //Passing roles so that only root factory has to set user current roles
        $roles = $factory->getRoles();
        if(empty($roles)) {
            $factory->setRoles($this->getRoles());
        }
        
        $this->createdSubItems[$name] = $factory;
    }

    public function create($arguments = array())
    {
        return $this->__invoke($arguments);
    }

    private function isAllowed()
    {
        $userRoles = $this->getRoles();
        $allowedRoles = $this->getAllowed();
        foreach($allowedRoles as $allowed) {
            foreach($userRoles as $role) {
                if($role == $allowed) {
                    return true;
                }
            }
        }
        return empty($allowedRoles);
    }

    /**
     * @param array $arguments
     * @return object
     * @throws Exception\NotAllowed
     */
    public function __invoke($arguments = array())
    {
        if(!$this->isAllowed()) {
            throw new NotAllowed('Not allowed for creating class '
                    . $this->getNamespace());
        }
        $class = $this->getNamespace();
        $arguments = is_array($arguments) ? $arguments : array();
        $options = array_merge($this->getInherited(),
            $this->getOptions(), $arguments);

        return new $class($options);
    }

    public function setOptions($options = array())
    {
        $this->options = array_merge($this->options, $options);
        return parent::setOptions($options);
    }

    /**
     * @param string $namespace
     * @return Factory
     */
    public function findFactoryByNamespace($namespace) {
        $namespaceLeft = substr($namespace,
                strlen($this->getNamespace()) + 1);
        $parts = explode('\\', $namespaceLeft);
        $currentFactory = $this;

        foreach($parts as $part) {
            $part = lcfirst($part);
            $currentFactory = $currentFactory->$part;
        }
        return $currentFactory;
    }
    
}
