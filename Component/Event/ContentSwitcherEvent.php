<?php

namespace NetCore\Component\Event;

use \NetCore\Event\Event;
use \NetCore\Component\ComponentAbstract;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 15.11.11
 * Time: 14:10
 */
class ContentSwitcherEvent extends Event
{

    const BEFORE_SWITCH = 'before_switch';
    const AFTER_SWITCH = 'after_switch';
    const CONTENT_NOT_FOUND = 'content_not_found';
    const BEFORE_POSSIBILITIES_CHANGE = 'before_possibilities_change';
    const AFTER_POSSIBILITIES_CHANGE = 'after_possibilities_change';

    /**
     * @var ComponentAbstract
     */
    private $newContent;

    public function __construct($name, $newContent = null)
    {
        parent::__construct($name);
        if($newContent) {
            $this->setNewContent($newContent);
        }

    }

    /**
     * @param \NetCore\Component\ComponentAbstract $content
     * @return ContentSwitcherEvent
     */
    public function setNewContent(ComponentAbstract $content)
    {
        $this->newContent = $content;
        return $this;
    }

    /**
     * @return ComponentAbstract
     */
    public function getNewContent()
    {
        return $this->newContent;
    }

}
