<?php

/**
 * exception thrown to report errors in operation, often as
 * a result of erroneous data supplied by the user
 * @author Habbes
 *
 */
class OperationException extends Exception
{
	private $operationErrors;
	
	/**
	 * 
	 * @param array $errors
	 * @param string $message
	 * @param number $code
	 * @param string $previous
	 */
	public function __construct($errors = [], $message = null, $code = 0, $previous = null)
	{
		$this->operationErrors = $errors;
		parent::__construct($message, $code, $previous);
		
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getErrors()
	{
		return $this->operationErrors;
	}
	
	/**
	 * 
	 * @param array $errors
	 */
	public function setErrors($errors)
	{
		$this->operationErrors = $errors;
	}
	
	/**
	 * 
	 * @param string $error
	 */
	public function addError($error)
	{
		$this->operationErrors[] = $error;
	}
	
	/**
	 * 
	 * @param string $error
	 * @return boolean
	 */
	public function hasError($error)
	{
		return array_searcher($error, $this->operationErrors);
	}
}