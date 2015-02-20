<?php

class PasswordRecovery extends DBModel
{
	
	protected static $table = "password_recovery";
	
	protected $user_id;
	protected $code;
	protected $expiry_date;
	protected $date_sent;
	protected $recovered = false;
	
	/**
	 * 
	 * @var User
	 */
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
		$pr->date_sent = Utils::dbDateFormat(time());
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
	
	/**
	 * @return string
	 */
	public function getCode()
	{
		return $this->code;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isRecovered()
	{
		return (boolean) $this->recovered;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isValid()
	{
		return !$this->isRecovered() && time() < $this->getExpiryDate();
	}
	
	/**
	 * 
	 * @param string $newpass new password
	 * @throws OperationException
	 */
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
	
	/**
	 * 
	 * @param User $user
	 * @return PasswordRecovery
	 */
	public static function findValidByUser($user)
	{
		$prs = static::findAllByField("user_id", $user->getId());
		foreach($prs as $pr){
			if ($pr->isValid())
				return $pr;
		}
		return null;
	}
	
	
}