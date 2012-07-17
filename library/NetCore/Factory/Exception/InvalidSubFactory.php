<?php

namespace NetCore\Factory\Exception;

use \NetCore\Factory\Exception;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 27.11.11
 * Time: 15:35
 */
class InvalidSubFactory extends \InvalidArgumentException implements Exception
{

    public function __construct ($message = 'Only subClasses of Factory can be properties of Factory instance',
        $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
