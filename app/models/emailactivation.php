<?php

/**
 * class used to activate email addresses
 * @author Habbes
 *
 */
class EmailActivation extends DBModel
{
	
	protected static $table = "email_activation";
	
	protected $user_id;
	protected $code;
	protected $expiry_date;
	protected $date_sent;
	protected $activated = false;
	protected $email;
	
	private $_user;
	
	const DEFAULT_VALIDITY = 48; //hours
	
	/**
	 * 
	 * @param User $user owner of the email address
	 * @param string $email email to activate (default is user's current email)
	 * @param number $validity validity period of the EmailActivation in hours
	 * @return EmailActivation
	 */
	public static function create($user, $email = null, $validity = null)
	{
		$ea = new static();
		$ea->user_id = $user->getId();
		$ea->_user = $user;
		$ea->email = $email? $email : $user->getEmail();
		$validity = $validity? $validity : self::DEFAULT_VALIDITY;
		$ea->expiry_date = Utils::dbDateFormat(time() + $validity * 3600);
		$ea->code = sha1(uniqid());
		return $ea;
	}
	
	/**
	 * @return User
	 */
	public function getUser()
	{
		if(!$this->_user){
			$this->_user = User::findById($this->user_id);
		}
		return $this->_user;
	}
	
	/**
	 *
	 * @return number timestamp
	 */
	public function getExpiryDate()
	{
		return strtotime($this->expiry_date);
	}
	
	/*
	 * @return number timestamp 
	 */
	public function getDateSent()
	{
		return strtotime($this->date_sent);
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isActivated()
	{
		return (boolean) $this->activated;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isValid()
	{
		return !$this->isActivated() && time() < $this->getExpiryDate()
			&& $this->email == $this->getUser()->getEmail();
	}
	
	/**
	 * activates the current email of the associated user
	 * @param string $password user's current password
	 * @return EmailActivation returns the instance of EmailActivation on success
	 */
	public function activate($password){
		
		if(!$this->isValid())
			throw new OperationException([OperationError::EMAIL_ACTIVATION_INVALID]);
		
		if(!$this->getUser()->verifyPassword($password))
			throw new OperationException([OperationError::USER_PASSWORD_INCORRECT]);
		
		$this->activated = true;
		
		$this->getUser()->setEmailActivated(true);
		$this->getUser()->save();
		return $this->save();
	}
	
	protected function onInsert(&$errors)
	{
		$this->date_sent = Utils::dbDateFormat(time());
		return true;
	}
	
	/**
	 * find the EmailActivation with the given code
	 * @param string $code
	 * @return EmailActivation
	 */
	public static function findByCode($code)
	{
		return static::findOneByField("code", $code);
	}
	
	/**
	 * find a valid EmailActivation for the specified user
	 * @param User $user
	 * @return EmailActivation
	 */
	public static function findValidByUser($user)
	{
		$eas = static::findAllByField("user_id", $user->getId());
		foreach($eas as $ea){
			if ($ea->isValid())
				return $ea;
		}
		return null;		
	}
}