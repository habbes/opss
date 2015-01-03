<?php

/**
 * represents a secondary author for a paper
 * @author Habbes
 *
 */
class CoAuthor extends DBModel
{
	
	protected $name;
	protected $email;
	
	/**
	 * 
	 * @param string $name
	 * @param string $email
	 * @return CoAuthor
	 */
	public static function create($name, $email)
	{
		$author = new static();
		$author->name = $name;
		$author->email = $email;
		return $author;
	}
	
	public function validate(&$errors)
	{
		if(!User::isValidEmail($this->email))
			$errors[] = OperationError::USER_EMAIL_INVALID;
		
		return true;
	}
}