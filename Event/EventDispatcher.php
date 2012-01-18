<?php
/**
 * Author: Sel <s@finalclass.net>
 * Date: 10.11.11
 * Time: 11:15
 */

namespace NetCore\Event;

use \NetCore\Event\Event;
use \NetCore\Event\StaticEventDispatcher;


class EventDispatcher
{

    /**
     * @param $eventName
     * @param $listener
     * @return EventDispatcher
     */
    public function addEventListener($eventName, $listener)
    {
        StaticEventDispatcher::addEventListenerToObject($this, $eventName, $listener);
        return $this;
    }

    /**
     * @param $eventName
     * @param $listener
     * @return EventDispatcher
     */
    public function removeEventListener($eventName, $listener)
    {
        StaticEventDispatcher::removeObjectEventListener($this, $eventName, $listener);
        return $this;
    }

    /**
     * @param Event $event
     * @return EventDispatcher
     */
    public function dispatchEvent(Event $event)
    {
        StaticEventDispatcher::dispatchEventOnObject($this, $event);
        return $this;
    }

    public function hasEventListener($eventName, $listener)
    {
        return StaticEventDispatcher::hasObjectEventListener($this, $eventName, $listener);
    }



}
