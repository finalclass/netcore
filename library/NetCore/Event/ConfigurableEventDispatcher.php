<?php
/**
 * Author: Sel <s@finalclass.net>
 * Date: 10.11.11
 * Time: 16:00
 */

namespace NetCore\Event;

use \NetCore\Event\StaticEventDispatcher;
use \NetCore\Configurable\StaticConfigurator;

class ConfigurableEventDispatcher
{

    protected $options = array();

    /**
     * @param array $options
     */
    public function __construct($options = array())
    {
        $this->setOptions($options);
    }

    /**
     * @param array $options
     * @return ConfigurableEventDispatcher
     */
    public function setOptions($options = array())
    {
        $this->options = array_merge($this->options, $options);
        StaticConfigurator::setOptions($this, $options);
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * @param $eventName
     * @param $listener
     * @param bool $targetPhase default true
     * @return EventDispatcher
     */
    public function addEventListener($eventName, $listener, $targetPhase = true)
    {
        StaticEventDispatcher::addEventListenerToObject($this, $eventName, $listener, $targetPhase);
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
