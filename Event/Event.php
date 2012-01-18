<?php


namespace NetCore\Event;

/**
 * Common class for each Event in NetCore
 *
 * Author: MMP
 */
class Event {

    protected $name;
    protected $target;
        
    /**
     * Constructor setting name of the Event
     * 
     * @param string $name 
     */
    public function __construct($name)
    {
        $this->name=strval($name);
    }

    /**
     * Function gets name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Function gets target
     * 
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Function sets target
     * 
     * @param string $target 
     */
    public function setTarget($target)
    {
        $this->target=$target;
    }

}