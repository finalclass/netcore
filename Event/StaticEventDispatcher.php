<?php
/**
 * @TODO Zrobić aby ta klasa korzystała z traits gdy wyjdzie php 5.4
 *
 * Author: Sel <s@finalclass.net>
 * Date: 10.11.11
 * Time: 14:03
 */

namespace NetCore\Event;

use \NetCore\Event\Event;
use \NetCore\Event\Exception\ListenerNotCallable;

class StaticEventDispatcher
{

    /**
     * @static
     * @throws Exception\ListenerNotCallable
     * @param object $target
     * @param $eventName
     * @param $listener
     * @param bool $targetPhase
     * @return bool
     */
    static public function addEventListenerToObject($target, $eventName, $listener, $targetPhase = true)
    {
        if (!is_callable($listener)) {
            throw new ListenerNotCallable();
        }

        if (self::hasObjectEventListener($target, $eventName, $listener)) {
            return false;
        }
        $targetListeners = self::getObjectListenersByEventName($target, $eventName);
        $targetListeners[] = array($listener, $targetPhase);
        self::setObjectListenersByEventName($target, $eventName, $targetListeners);
        return true;
    }

    static public function hasObjectEventListener($object, $eventName, $listener)
    {
        $listeners = self::getObjectListenersByEventName($object, $eventName, $listener);
        foreach ($listeners as $foundListener) {
            if ($foundListener == $listener) {
                return true;
            }
        }
        return false;
    }

    /**
     * Dispatches the Event on the given target
     *
     * @static
     * @param \object $target
     * @param Event $event
     * @return bool true if at least one listener was called
     */
    static public function dispatchEventOnObject($target, Event $event)
    {
        $event->setCurrentTarget($target);

        if(!$event->getTarget()) {
            $event->setTarget($target);
        }
        $targetListeners = self::getObjectListenersByEventName($target, $event->getName());
        foreach ($targetListeners as $listenerDefinition) {
            $listener = $listenerDefinition[0];
            $targetPhase = $listenerDefinition[1];
            if( ($targetPhase && $event->getTarget() == $event->getCurrentTarget()) || !$targetPhase) {
                call_user_func($listener, $event);
            }
        }
        //Bublink
        if ($event->getBubble() && method_exists($target, 'getParent')) {
            $parent = $target->getParent();
            if($parent) {
                self::dispatchEventOnObject($parent, $event);
            }
        }
        return !empty($targetListeners);
    }

    static public function removeObjectEventListener($target, $eventName, $listener)
    {
        $targetListeners = self::getObjectListenersByEventName($target, $eventName);
        $foundKey = array_search($listener, $targetListeners, true);
        if ($foundKey === false) {
            return false;
        }
        array_splice($targetListeners, $foundKey, 1);
        self::setObjectListenersByEventName($target, $eventName, $targetListeners);
        return true;
    }

    static private function getObjectListenersByEventName($target, $eventName)
    {
        $listeners = isset($target->__listeners) ? $target->__listeners : array();
        return isset($listeners[$eventName]) ? $listeners[$eventName] : array();
    }

    static private function setObjectListenersByEventName($target, $eventName, $listeners)
    {
        $eventName = (string)$eventName;
        if (!isset($target->__listeners)) {
            $target->__listeners = array();
        }
        $target->__listeners[$eventName] = $listeners;
    }


}
