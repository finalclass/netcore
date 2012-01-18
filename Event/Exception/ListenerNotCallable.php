<?php

/**
 * Class ListenerNotCallable
 *
 * Author: MMP
 */
 
namespace NetCore\Event\Exception;

class ListenerNotCallable extends \InvalidArgumentException implements \NetCore\Event\Exception {

    /**
     * @param string $message default value = "ListenerNotCallable"
     * @param int $code default value = 0
     * @param string $previous default value =null
     */
    
    public function __construct($message='ListenerNotCallable', $code=0, $previous=null) {
        parent::__construct($message, $code, $previous);
    }

}