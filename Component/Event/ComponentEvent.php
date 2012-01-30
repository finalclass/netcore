<?php

namespace NetCore\Component\Event;

use \NetCore\Event\Event;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 15.11.11
 * Time: 11:26
 */
class ComponentEvent extends Event
{

    const BEFORE_CONSTRUCT = 'before_construct';
    const AFTER_CONSTRUCT = 'after_construct';
    const BEFORE_INITIALIZE = 'before_initialize';
    const AFTER_INITIALIZE = 'after_initialize';
    const BEFORE_RENDER = 'before_render';
    const AFTER_RENDER = 'after_render';
    const BEFORE_SET_PARENT = 'before_set_parent';
    const AFTER_SET_PARENT = 'after_set_parent';
    const CREATION_COMPLETE = 'creation_complete';

    public function __construct($name)
    {
        parent::__construct($name);
    }


}
