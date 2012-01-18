<?php

namespace NetCore\Component\Exception;

use \NetCore\Component\Exception as ComponentException;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 05.12.11
 * Time: 14:26
 */
class NotAComponent
    extends \InvalidArgumentException
    implements ComponentException
{

}
