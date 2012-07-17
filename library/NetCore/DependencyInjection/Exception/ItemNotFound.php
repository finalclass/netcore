<?php

namespace NetCore\DependencyInjection\Exception;

use \NetCore\DependencyInjection\Exception as DependencyInjectionException;

/**
 * Author: Szymon Wygnański
 * Date: 06.09.11
 * Time: 05:33
 */
class ItemNotFound extends \InvalidArgumentException  implements DependencyInjectionException
{

}
