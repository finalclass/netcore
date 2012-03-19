<?php

namespace NetCore\Router;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 05.12.11
 * Time: 17:15
 */
class Router
{

    /**
     * @var \NetCore\Router\Route[]
     */
    private $routes = array();

    private $domainRoutes = array();

    /**
     * @var \NetCore\Router\Route[]
     */
    private $sortedByStaticLength = null;

    /**
     * @var \NetCore\Router\Route[]
     */
    private $sortedByNumberOfParams = null;

    public function addRoute($name, $pattern, $operations = array(), $params = array())
    {
        if (isset($this->routes[$name])) {
            throw new RouteWithSameNameExists('Route ' . $name . ' already exists');
        }
        $this->routes[$name] = new Route($name, $pattern, $operations, $params);
        $this->sortedByStaticLength = null;
        $this->sortedByNumberOfParams = null;

        return $this;
    }

    /**
     * @param $name
     * @return Route|null
     */
    public function getRoute($name)
    {
        return isset($this->routes[$name]) ? $this->routes[$name] : null;
    }

    public function findRouteByUri($uri)
    {
        if ($this->sortedByStaticLength == null) {
            $this->rebuildSortedByStaticRoutes();
        }

        foreach ($this->sortedByStaticLength as $route) {
            if ($route->testUri($uri)) {
                return $route;
            }
        }
        return null;
    }

    public function findRoute($params)
    {
        if ($this->sortedByNumberOfParams == null) {
            $this->rebuildSortedByNumberOfParams();
        }

        foreach ($this->sortedByNumberOfParams as $route) {
            if ($route->testRoute($params)) {
                return $route;
            }
        }
        return null;
    }

    private function rebuildSortedByNumberOfParams()
    {
        $this->sortedByNumberOfParams = $this->routes;
        usort($this->sortedByNumberOfParams, function(Route $a, Route $b)
        {
            $aParamsQuantity = count($a->getParamsFromPattern());
            $bParamsQuantity = count($b->getParamsFromPattern());
            if ($aParamsQuantity > $bParamsQuantity) {
                return -1;
            } else if ($aParamsQuantity < $bParamsQuantity) {
                return 1;
            } else {
                return 0;
            }
        });
    }

    private function rebuildSortedByStaticRoutes()
    {
        $this->sortedByStaticLength = $this->routes;
        usort($this->sortedByStaticLength, function(Route $a, Route $b)
        {
            $aLen = $a->getStaticPatternPartsLength();
            $bLen = $b->getStaticPatternPartsLength();
            if ($aLen > $bLen) {
                return -1;
            } else if ($aLen < $bLen) {
                return 1;
            } else {
                return 0;
            }
        });
    }

}
