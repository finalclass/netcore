<?php

/**
 * Exception
 *
 * @author Szymon Wygnański
 */
class Sel_Validate_Exception extends Exception {
    
	/**
	 *
	 * @var Sel_Validate_Errors
	 */
	private $errorStack;

	public function __construct(Sel_Validate_ErrorStack $errorStack = null)
	{
		$this->errorStack = $errorStack;
	}

	/**
	 *
	 * @return Sel_Validate_Errors
	 */
	public function getErrorStack()
	{
		return $this->errorStack;
	}

}