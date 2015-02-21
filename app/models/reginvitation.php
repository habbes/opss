<?php

/**
 * represents an invitation sent by an admin allow someone to register
 * @author Habbes
 *
 */
class RegInvitation extends DBModel
{
	
	protected $admin_id;
	protected $user_id;
	protected $user_type;
	protected $paper_id;
	protected $name;
	protected $email;
	protected $date_sent;
	protected $date_registered;
	protected $expiry_date;
	protected $status;
	protected $registration_code;
	
	private $_user;
	private $_admin;
	private $_paper;
	
	const PENDING = 1;
	const EXPIRED = 2;
	const REGISTRERED = 3;
	const DECLINED = 4;
	const CANCELLED = 5;
	
	const DEFAULT_VALIDITY = 7; //days
	
	/**
	 * 
	 * @param User $admin
	 * @param int $userType UserType
	 * @param string email
	 * @param int $validity validity of the invitation in days
	 * @return RegInvitation
	 */
	public static function create($admin, $userType, $email, $validity = null)
	{
		$inv = new static();
		$inv->_admin = $admin;
		$inv->admin_id = $admin->getId();
		$inv->user_type = $userType;
		$inv->email = $email;
		$validity = $validity? $validity : self::DEFAULT_VALIDITY;
		$inv->expiry_date = Utils::dbDateFormat(time() + $validity * 86400);
		$inv->registration_code = Utils::uniqueRandomCode();
		$inv->status = self::PENDING;
		
		return $inv;
	}
	
	/**
	 * checks whether the invitation is supposed to be expired
	 * and saves the status if necessary
	 */
	private function checkValidity()
	{
		if($this->status == self::PENDING){
			$date = $this->getExpiryDate();
			if($this->getExpiryDate() >= time()){
				$this->status == self::EXPIRED;
				$this->save();
			}
		}
	}
	
	/**
	 * filters a list of invitationsand returns only valid ones
	 * @param array(RegInvitation) $invs
	 * @return array(RegInvitation)
	 */
	private static function filterValid($invs)
	{
		
		return array_filter($invs, function($inv){
			return $inv->isValid();
		});
	}
	
	/**
	 * the admin who sent this invitation
	 * @return User
	 */
	public function getAdmin()
	{
		if(!$this->_admin)
			$this->_admin = User::findById($this->admin_id);
		return $this->_admin;
	}
	
	/**
	 * the user who registered with this invitation
	 * @return User
	 */
	public function getUser()
	{
		if(!$this->_user)
			$this->_user = User::findById($this->user_id);
		return $this->_user;
	}
	
	/**
	 * the user type allowed to be registered
	 * @return number UserType
	 */
	public function getUserType()
	{
		return (int) $this->user_type;
	}
	
	/**
	 * 
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * if this invitation is to a reviewer, this
	 * sets the paper to review
	 * @param Paper $paper
	 */
	public function setPaper($paper)
	{
		if($this->isInDb())
			return;
		$this->_paper = $paper;
		$this->paper_id = $paper->getId();
	}
	
	/**
	 * 
	 * @return Paper
	 */
	public function getPaper()
	{
		if(!$this->_paper)
			$this->_paper = Paper::findById($this->paper_id);
		return $this->_paper;
	}
	
	/**
	 * 
	 * @return number timestamp
	 */
	public function getDateSent()
	{
		return strtotime($this->date_sent);
	}
	
	/**
	 * 
	 * @return number timestamp
	 */
	public function getExpiryDate()
	{
		return strtotime($this->expiry_date);
	}
	
	/**
	 * 
	 * @return number timestamp
	 */
	public function getDateRegistered()
	{
		return strtotime($this->date_registered);
	}
	
	/**
	 * the registration code
	 * @return string
	 */
	public function getRegistrationCode()
	{
		return $this->registration_code;
	}
	
	/**
	 * 
	 * @return number PENDING, REGISTERED or EXPIRED
	 */
	public function getStatus()
	{
		return (int) $this->status;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isValid()
	{
		$this->checkValidity();
		return $this->status == self::PENDING;
	}
	
	/**
	 * register the user who responded to the invitation
	 * and deletes this invitation
	 * @param User $user
	 */
	public function register($user)
	{
		/*
		$this->_user = $user;
		$this->user_id = $user->getId();
		$this->date_registered = Utils::dbDateFormat(time());
		$this->status = self::REGISTERED;
		$this->update();
		*/
		$this->delete();
	}
	
	/**
	 * decline the invitation
	 */
	public function decline()
	{
		$this->status = self::DECLINED;
		$this->save();
		$this->delete();
	}
	
	/**
	 * cancels and deletes the invitation
	 */
	public function cancel()
	{
		$this->status = self::CANCELLED;
		$this->save();
		$this->delete();
	}
	
	protected function onInsert(&$errors)
	{
		$this->date_sent = Utils::dbDateFormat(time());
		return true;
	}
	
	protected function validate(&$errors)
	{
		if(!UserType::isValue($this->getUserType()))
			$errors[] = OperationError::USER_TYPE_INVALID;
		if($this->isInDb() && ($this->_user && ($this->_user->getType() != $this->getUserType())))
			$errors[] = OperationError::USER_TYPE_INVALID;
		
		return true;
		
	}
	
	/**
	 * 
	 * @param string $code registration code
	 * @return RegInvitation
	 */
	public static function findValidByCode($code)
	{
		$inv = static::findOne(
				"registration_code=? AND status=?",
				[$code, self::PENDING]
				);
		if($inv && $inv->isValid())
			return $inv;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return array(RegInvitation)
	 */
	public static function findValidByPaper($paper)
	{
		$invs = static::findAllByField("paper_id", $paper->getId());
		return static::filterValid($invs);
		return $invs;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @param int $id
	 * @return RegInvitation
	 */
	public static function findValidByPaperAndId($paper, $id)
	{
		$inv = static::findOne("id=? AND paper_id=? AND status=?",[
				$id, $paper->getId(), self::PENDING
		]);
		if($inv && $inv->isValid())
			return $inv;
		return null;
	}
	
	
}