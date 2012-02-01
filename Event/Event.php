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
    protected $currentTarget;
    protected $bubble = true;

    /**
     * Constructor setting name of the Event
     *
     * @param string $name
     * @param bool $bubble
     */
    public function __construct($name, $bubble = true)
    {
        $this->name=strval($name);
        $this->bubble = $bubble == true;
    }

    public function getBubble()
    {
        return $this->bubble;
    }

    public function stopPropagation()
    {
        $this->bubble = false;
        return $this;
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
     * @return \NetCore\Event\Event
     */
    public function setTarget($target)
    {
        $this->target=$target;
        return $this;
    }

    public function setCurrentTarget($curTarget)
    {
        $this->currentTarget = $curTarget;
        return $this;
    }

    public function getCurrentTarget()
    {
        return $this->currentTarget;
    }

}