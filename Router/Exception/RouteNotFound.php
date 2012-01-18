<?php

namespace NetCore\Router\Exception;

use NetCore\Router\Exception as RouterException;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 07.12.11
 * Time: 10:53
 */
class RouteNotFound
    extends \InvalidArgumentException
    implements RouterException
{

}
