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
	protected $date_added;
	
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
	
	/**
	 *
	 * @return number timestamp
	 */
	public function getDateAdded()
	{
		return strtotime($this->date_added);
	}
	
	protected function validate(&$errors)
	{
		if(!User::isValidEmail($this->email))
			$errors[] = OperationError::USER_EMAIL_INVALID;
		
		return true;
	}

	protected function onInsert(&$errors)
	{
		$this->date_added = Utils::dbDateFormat(time());
		return true;
	}
}