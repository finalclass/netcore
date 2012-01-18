<?php

namespace NetCore\Doctrine;

use \NetCore\Configurable\OptionsAbstract;

/**
 * Author: Szymon Wygnański
 * Date: 20.09.11
 * Time: 17:28
 */
class ConnectionOptions extends OptionsAbstract implements \ArrayAccess
{

    protected $options = array(
        'driver' => 'pdo_mysql',
        'path' => '127.0.0.1',
        'dbname' => 'netbricks',
        'user' => 'netbricks',
        'password' => 'netbricks'
    );

    static public function factory($options = array())
    {
        return new ConnectionOptions($options);
    }

    public function __invoke($data = array())
    {
        return $this->setOptions($data);
    }

    /**
     * @param $value
     * @return \Fc\Doctrine\ConnectionOptions
     */
    public function setDriver($value)
    {
        $this->options['driver'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDriver()
    {
        return isset($this->options['driver']) ? $this->options['driver'] : 'pdo_mysql';
    }

    /**
     * @param $value
     * @return \Fc\Doctrine\ConnectionOptions
     */
    public function setPath($value)
    {
        $this->options['path'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return isset($this->options['path']) ? $this->options['path'] : '127.0.0.1';
    }


    /**
     * @param $value
     * @return \Fc\Doctrine\ConnectionOptions
     */
    public function setDbname($value)
    {
        $this->options['dbname'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDbname()
    {
        return isset($this->options['dbname']) ? $this->options['dbname'] : 'fc';
    }

    /**
     * @param $value
     * @return \Fc\Doctrine\ConnectionOptions
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
        return isset($this->options['user']) ? $this->options['user'] : 'fc_user';
    }

    /**
     * @param $value
     * @return \Fc\Doctrine\ConnectionOptions
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
        return isset($this->options['password']) ? $this->options['password'] : 'fc_pass';
    }


    // ---------------------------
    // ArrayAccess implementation
    // ---------------------------

    public function offsetExists($offset)
    {
        return isset($this->options[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->options[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->options[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->options[$offset]);
    }
}