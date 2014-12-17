<?php

class ValidationException extends Exception
{
	private $validationErrors;
	
	public function __construct($message = null, $code = 0, $previous = null)
	{
		$this->validationErrors = [];
		parent::__construct($message, $code, $previous);
		
	}
	
	public function getErrors()
	{
		return $this->validationErrors;
	}
	
	public function setErrors($errors)
	{
		$this->validationErrors = $errors;
	}
	
	public function addError($error)
	{
		$this->validationErrors[] = $error;
	}
	
	public function hasError($error)
	{
		return array_searcher($error, $this->validationErrors);
	}
}