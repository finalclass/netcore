<?php

namespace NetCore\DependencyInjection\Exception;

use \NetCore\DependencyInjection\Exception as DependencyInjectionException;

/**
 * Author: Szymon Wygnański
 * Date: 06.09.11
 * Time: 03:56
 */
class DependencyNotFound extends \InvalidArgumentException implements DependencyInjectionException {

}
