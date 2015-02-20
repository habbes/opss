<?php

class PasswordRecovery extends DBModel
{
	
	protected static $table = "password_recovery";
	
	protected $user_id;
	protected $code;
	protected $expiry_date;
	protected $date_sent;
	protected $recovered = false;
	
	private $_user;
	
	const DEFAULT_VALIDITY = 2; //hours

	/**
	 * 
	 * @param User $user
	 * @param int $validity validity period in hourse
	 * @return PasswordRecovery
	 */
	public static function create($user, $validity = null)
	{
		$pr = new static();
		$pr->user_id = $user->getId();
		$pr->_user = $user;
		$validity = $validity? $validity : self::DEFAULT_VALIDITY;
		$pr->expiry_date = Utils::dbDateFormat(time() + $validity * 3600);
		$pr->code = Utils::uniqueRandomCode();
		$pr->recovered = false;
		$pr->date_sent = Utls::dbDateFormat(time());
		return $pr;
	}
	
	/**
	 * 
	 * @return User
	 */
	public function getUser()
	{
		if(!$this->_user)
			$this->_user = User::findById($this->user_id);
		return $this->_user;
	}
	
	/**
	 * 
	 * @return number
	 */
	public function getExpiryDate()
	{
		return strtotime($this->expiry_date);
	}
	
	/**
	 * 
	 * @return number
	 */
	public function getDateSent()
	{
		return strtotime($this->date_sent);
	}
	
	public function isRecovered()
	{
		return (boolean) $this->recovered;
	}
	
	public function isValid()
	{
		return !$this->isActivated() && time() < $this->getExpiryDate();
	}
	
	public function recover($newpass)
	{
		if(!$this->isValid())
			throw new OperationException([OperationError::PASS_RECOVERY_INVALID]);
		$this->getUser()->setPassword($newpass);
		$this->getUser()->save();	
		$this->recovered = true;
		$this->save();
		$this->delete();
	}
	
	/**
	 * 
	 * @param string $code
	 * @return PasswordRecovery
	 */
	public static function findValidByCode($code)
	{
		$pr = static::findOneByField("code", $code);
		if($pr && $pr->isValid())
			return $pr;
		return null;
	}
	
	
}