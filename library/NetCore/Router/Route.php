<?php

namespace NetCore\Router;

use \NetCore\Router\Exception\ParamNotFound;
use \NetBricks\Facade as _;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 05.12.11
 * Time: 17:16
 */
class Route
{

    /**
     * Array of pattern. Usually looks like that:
     * array('edit-article-', '{id}'}
     *
     * @var array
     */
    private $pattern;

    /**
     * Array of params found in pattern and specified by user
     *
     * @var array
     */
    private $params;

    /**
     * Required params are the params that are found in the pattern
     *
     * @var array
     */
    private $urlParams;

    /**
     * @var array
     */
    private $staticParams;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array()
     */
    private $requiredParams;

    public function __construct($name, $pattern, $params = array())
    {
        $this->name = $name;
        $pattern = $this->addPrecedingSlash($pattern);
        $this->pattern = $this->explodePattern($pattern);
        $this->urlParams = $this->getParamsFromPattern();
        $this->staticParams = $params;
        $this->requiredParams = $this->getRequiredParams();

        $this->params = array_merge($this->urlParams, $this->staticParams);
    }

    public function getName()
    {
        return $this->name;
    }

    public function testRoute($params = array())
    {
        //All static params are same in given $params
        foreach ($this->staticParams as $key => $val) {
            if (!isset($params[$key]) || $params[$key] != $val) {
                return false;
            }
        }

        //All dynamic params exists in $params
        foreach($this->urlParams as $key=>$val) {
            if(!isset($params[$key])) {
                return false;
            }
        }
        return true;
        /*$paramsDifference = $this->fullArrayDiff(array_keys($this->urlParams), array_keys($params));
        return empty($paramsDifference);*/
    }

    private function getRequiredParams()
    {
        $params = array();
        foreach($this->urlParams as $key=>$val) {
            if(!isset($this->params[$key])) {
                $params[$key] = $val;
            }
        }
        return $params;
    }

    private function fullArrayDiff($left, $right)
    {
        return array_diff(array_merge($left, $right), array_intersect($left, $right));
    }

    public function addPrecedingSlash($string)
    {

        if (empty($string)) {
            $string = '/';
        }
        if ($string[0] != '/') {
            $string = '/' . $string;
        }
        return $string;
    }

    public function buildUri($requiredParams, $additionalParams = array())
    {
        $url = array();
        $paramsLeftNotBound = $requiredParams;
        $allParams = array_merge($this->params, $additionalParams, $requiredParams);

        foreach ($this->pattern as $part) {
            if ($part[0] == '{') {
                $withoutBraces = str_replace(array('{', '}'), '', $part);
                if (empty($allParams[$withoutBraces])) {
                    throw new ParamNotFound('Param ' . $withoutBraces . ' not found');
                }
                unset($paramsLeftNotBound[$withoutBraces]);
                $url[] = $allParams[$withoutBraces];
            } else {
                $url[] = $part;
            }
        }

        foreach($this->params as $key=>$val) {
            unset($paramsLeftNotBound[$key]);
        }

        $rest = array();
        if(!empty($paramsLeftNotBound)) {
            foreach($paramsLeftNotBound as $key=>$val) {
                $rest[] = $key . '=' . $val;
            }
        }
        $rest = empty($rest) ? '' : '?' . join('&', $rest);
        return join('', $url) . $rest;
    }

    public function testUri($uri)
    {
        $uri = $this->addPrecedingSlash($uri);
        if (!$this->areParametersInPattern()) {
            return strcmp($this->pattern[0], $uri) == 0;
        }

        $offset = 0;
        foreach ($this->pattern as $part) {
            if ($part[0] == '{') {
                continue;
            }
            $offset = strpos($uri, $part, $offset);
            if ($offset === false) {
                return false;
            }
            $offset += strlen($part);
        }
        return true;
    }

    public function getStaticPatternPartsLength()
    {
        return strlen(join('', $this->getStaticPatternParts()));
    }

    public function getParamsFromPattern()
    {
        $out = array();
        foreach($this->pattern as $part) {
            if($part[0] == '{') {
                $out[] = $part;
            }
        }
        return $this->removeBraces(array_flip($out));
    }

    public function getParamsForUri($uri)
    {
        $uri = $this->addPrecedingSlash($uri);
        $params = $this->params;

        //First find the offsets of static parts of the url
        $offsets = array();
        $end = 0;
        $start = 0;
        foreach ($this->pattern as $part) {
            if ($part[0] == '{') { // is parameter, not static part
                continue;
            }
            $start = strpos($uri, $part, $end);
            $end = $start + strlen($part);
            $offsets[] = array($start, $end);
        }

        //Now flat the offsets to get one dimensional array of this offsets
        $arr = array();
        foreach ($offsets as $offset) {
            $arr[] = $offset[0];
            $arr[] = $offset[1];
        }
        if (empty($arr)) {
            $arr[] = 0;
        }
        $arr[] = strlen($uri); //add last offset - length of the url
        if ($this->pattern[0][0] != '{') {
            //if pattern does not start from parameter
            array_shift($arr); //remove first element
        }

        //Now convert flat array into 2-dimensional array
        //This time we will get array of params offsets. Not static parts but dynamic parts
        $paramsOffsets = array();
        $len = count($arr) - 1;
        for ($i = 0; $i < $len; $i += 2) {
            $paramsOffsets[] = array($arr[$i], $arr[$i + 1]);
        }

        //now use substr and params offsets array to create params object
        //get params names from the pattern

        $i = 0;
        foreach ($this->pattern as $part) {
            if ($part[0] != '{') {
                continue;
            }
            $start = $paramsOffsets[$i][0];
            $end = $paramsOffsets[$i][1];
            $params[$part] = substr($uri, $start, $end - $start);
            $i++;
        }

        return array_merge($this->params, $this->removeBraces($params));
    }

    private function areParametersInPattern()
    {
        foreach ($this->pattern as $part) {
            if ($part[0] == '{') {
                return true;
            }
        }
        return false;
    }

    private function getStaticPatternParts()
    {
        $out = array();
        foreach ($this->pattern as $part) {
            if ($part[0] != '{') {
                $out[] = $part;
            }
        }
        return $out;
    }



    private function explodePattern($pattern)
    {
        if (empty($pattern)) {
            return array();
        }

        $exploded = array_values(
            array_filter(
                explode('*',
                    str_replace(array('{', '}'), '*', $pattern))));

        $startFromParam = $pattern[0] == '{';

        list($odd, $even) = $this->alternatelyDivideArray($exploded);

        if ($startFromParam) {
            $this->addBraces($even);
        } else {
            $this->addBraces($odd);
        }

        return $this->alternatelyConnect($odd, $even);
    }

    private function alternatelyDivideArray($array)
    {
        $odd = array();
        $even = array();
        $len = count($array);
        for ($i = 0; $i < $len; $i++) {
            if ($i % 2 == 1) {
                $odd[] = $array[$i];
            } else {
                $even[] = $array[$i];
            }
        }
        return array($odd, $even);
    }

    private function alternatelyConnect($arr1, $arr2)
    {
        $out = array();
        $len = count($arr1) + count($arr2);
        for ($i = 0; $i < $len; $i++) {
            $out[] = ($i % 2 == 1) ? array_shift($arr1) : array_shift($arr2);
        }
        return $out;
    }

    private function addBraces(&$arr)
    {
        $len = count($arr);
        for ($i = 0; $i < $len; $i++) {
            $arr[$i] = '{' . $arr[$i] . '}';
        }
        return $arr;
    }

    private function removeBraces($array)
    {
        $out = array();
        foreach ($array as $key => $val) {
            $key = str_replace(array('{', '}'), '', $key);
            $out[$key] = $val;
        }
        return $out;
    }

}
