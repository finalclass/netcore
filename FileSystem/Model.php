<?php

namespace NetCore\FileSystem;

use \NetCore\Configurable\StaticConfigurator;

/**
 * Model
 *
 * Author: Misiorus Maximus!
 */
abstract class Model
{

    public static $dirs = array();
    protected $data = array('id' => '');
    protected $array = array();
    protected $sortedArray = array();

//  protected $sortOrder;


    public function __construct()
    {

    }

    /**
     * This function should return for example "title"
     */
    abstract protected function getFieldToGenerateId();

    static public function setDir($filesDir)
    {
        static::$dirs[get_called_class()] = $filesDir;
    }

    static public function getDir()
    {
        $class = get_called_class();
        return isset(self::$dirs[$class]) ? self::$dirs[$class] : '';
    }

    public function delete()
    {

        if (empty($this->data['id'])) {
            return false;
        }
        $id = basename($this->data['id']);
        $result = unlink(static::getDir() . DIRECTORY_SEPARATOR . $id . '.json');
        return $result;
    }

    /**
     *
     * This function finds an object with given $id.
     * If such an object does not exist, the function will return null.
     * Otherwise, it will return a Model
     *
     * @param string $id
     * @return Model or null if not found
     */
    static public function find($id)
    {

        $path = static::getDir() . DIRECTORY_SEPARATOR . $id . '.json';
        $result = @file_get_contents($path);

        if ($result === false) {
            return null;
        }
        $data = \Zend_Json::decode($result);
        $className = get_called_class();
        $model = new $className();
        $model->fromArray($data);
        return $model;
    }

    /**
     *
     * This function finds and sorts all models by default sort criteria
     * $sortBy = 'id', and default sort direction $direction = 'asc' (ascending).
     * Returns sorted array of Model.
     *
     *
     * @param string $sortBy
     * @param string $direction
     * @return Model[]
     */
    static public function findAll($sortBy = 'id', $direction = 'asc')
    {

        $files = scandir(self::getDir());
        $array = array();
        foreach ($files as $file) {
            $filePath = self::getDir() . DIRECTORY_SEPARATOR . $file;
            if (!is_file($filePath) || substr($filePath, strlen($filePath) - 5) != '.json') {
                continue;
            }
            $data = \Zend_Json::decode(file_get_contents($filePath));
            $className = get_called_class();
            $model = new $className();
            $model->fromArray($data);
            $array[] = $model;
        }
        return static::sort($array, $sortBy, $direction);
    }

//    abstract protected function setSortByAndDirection() {
//        
//    }


    /**
     *
     * This function sorts all data by default $sortBy = 'id', and default sorting
     * direction $direction = 'asc' (ascending).
     * Returns sorted array of $data.
     *
     * @param array $data
     * @param \NetCore\FileSystem\type|string $sortBy
     * @param \NetCore\FileSystem\type|string $direction
     * @return array
     */
    static public function sort(array $data, $sortBy = 'id', $direction = 'asc')
    {

        $sortFunction = function($a, $b) use ($sortBy, $direction)
        {
            $methodName = 'get' . StaticConfigurator::toPascalCased($sortBy);
            $aVal = $a->$methodName();
            $bVal = $b->$methodName();

            if(is_int($aVal) && is_int($bVal)) {
                if($aVal > $bVal) {
                    return $direction == 'asc' ? 1 : -1;
                } else if($aVal < $bVal) {
                    return $direction == 'asc' ? -1 : 1;
                } else {
                    return 0;
                }
            }

            if ($direction == 'asc')
                return strcmp($aVal, $bVal);
            else
                return strcmp($aVal, $bVal);
        };
        usort($data, $sortFunction);
        return $data;
    }

    /* static public function sortInCStyle() {
     * }
     */

    public function fromArray($array)
    {

        $this->data = $array;
        return $this;
    }

    public function toArray()
    {
        return $this->data;
    }

    private function generateUniqueId($title)
    {
        $index = 0;
        $title = $id = $this->urlize($title);
        if (empty($title)) {
            $title = $id = 'item';
        }
        do {
            if ($index > 0)
                $id = ($title . '-' . $index);
            $index++;
        } while (file_exists(static::getDir() . DIRECTORY_SEPARATOR . $id . '.json'));
        return $id;
    }

    private function urlize($string)
    {
        return strtolower(preg_replace(array('/[^-a-zA-Z0-9\s]/', '/[\s]/'), array('', '-'), $string));
    }

    public function save()
    {

        if (empty($this->data['id'])) {
            //pusty id czyli insert, czyli trzeba stworzyc id
            $fieldName = $this->getFieldToGenerateId();
            $field = isset($this->data[$fieldName]) ? $this->data[$fieldName] : '';
            $this->data['id'] = $this->generateUniqueId($field);
        }

        $stringToSave = \Zend_Json::prettyPrint(\Zend_Json::encode($this->data), array('indent' => '  '));
        file_put_contents((static::getDir() . DIRECTORY_SEPARATOR . $this->data['id'] . '.json'), $stringToSave);
        return $this->data['id'];
    }

//    public function setId($value) {
//        $this->options['var_name'] = $value;
//        return $this;
//    }
//
    public function getId()
    {
        return empty($this->data['id']) ? '' : $this->data['id'];
    }

    public function setData($value)
    {
        $this->data = $value;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

}