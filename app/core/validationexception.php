<?php

class ValidationException extends Exception
{
	private $validationErrors;
	
	/**
	 * 
	 * @param array $errors
	 * @param string $message
	 * @param number $code
	 * @param string $previous
	 */
	public function __construct($errors = [], $message = null, $code = 0, $previous = null)
	{
		$this->validationErrors = $errors;
		parent::__construct($message, $code, $previous);
		
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getErrors()
	{
		return $this->validationErrors;
	}
	
	/**
	 * 
	 * @param array $errors
	 */
	public function setErrors($errors)
	{
		$this->validationErrors = $errors;
	}
	
	/**
	 * 
	 * @param string $error
	 */
	public function addError($error)
	{
		$this->validationErrors[] = $error;
	}
	
	/**
	 * 
	 * @param string $error
	 * @return boolean
	 */
	public function hasError($error)
	{
		return array_searcher($error, $this->validationErrors);
	}
}