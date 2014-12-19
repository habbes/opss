<?php

/**
 * represents a user
 * @author Habbes
 *
 */
class User extends DBModel
{
	protected $username;
	protected $password;
	protected $email;
	protected $title;
	protected $first_name;
	protected $last_name;
	protected $type;
	protected $date_added;
	protected $email_activated;
	
	protected $address;
	protected $residence;
	protected $nationality;
	protected $gender;
	
	private $_messageBox;
	private $_thematicAreas;
	private $_collaborativeAreas;
	private $_role;
	
	/**
	 * 
	 * @return number
	 */
	public function getDateAdded()
	{
		return strtotime($this->date_added);
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getFullName()
	{
		$name = $this->first_name . " " . $this->last_name;
		if($this->title)
			$name = $title . " " . $name;
		return $name;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isEmailActivated()
	{
		return (boolean) $this->email_activated;
	}
	
	/**
	 * 
	 * @return number
	 */
	public function getType()
	{
		return (int) $this->type;
	}
	
	/**
	 * 
	 * @return number
	 */
	public function getGender()
	{
		return (int) $this->gender();
	}
	
	/**
	 * 
	 * @param string $password
	 * @return boolean
	 */
	public function setPassword($password)
	{
		if($this->isInDb())
			return false;
		$this->password = Utils::hashPassword($password);
		return true;
	}
	
	/**
	 * check whether the given password is the user's password
	 * @param string $password
	 * @return boolean
	 */
	public function verifyPassword($password)
	{
		return Utils::verifyPassword($password, $this->password);
	}
	
	/**
	 * attempts to change the password of the user
	 * @param string $new password to set
	 * @param string $old current password
	 * @return boolean whether the password was changed
	 */
	public function changePassword($new, $old)
	{
		if(!$this->verifyPassword($old)){
			return false;
		}
		$this->password = Utils::hashPassword($new);
		return true;
	}
	
	public function addThematicArea($area)
	{
		
	}
	
	public function getThematicAreas()
	{
		if(!$this->_thematicAreas){
			$areas = UserResearchArea::findThematicByUser($this);
			$this->_thematicAreas = array();
			foreach($areas as $area){
				$this->_thematicAreas[] = $area->getGroup();
			}
		}
		return $this->_thematicAreas;
			
	}
	
	public function addCollaborativeArea($area)
	{
		
	}
	
	public function getCollaborativeAreas()
	{
		if(!$this->_collaborativeAreas){
			$areas = UserResearchArea::findCollaborativeByUser($this);
			$this->_collaborativeAreas = array();
			foreach($areas as $area){
				$this->_collaborativeAreas[] = $area->getGroup();
			}
		}
		
		return $this->_collaborativeAreas;
	}
	
	/**
	 * checks whether a user with the given credentials exists
	 * and returns that User
	 * @param string $username username or email
	 * @param string $password
	 * @return User
	 */
	public static function login($username, $password)
	{
		if($user = static::findByUsernameOrEmail($username)){
			if($user->verifyPassword($password)){
				return $user;
			}
		}
		return null;
	}
	
	/**
	 * get the role associated with this user
	 * @return UserRole
	 */
	public function getRole()
	{
		if(!$this->_role)
			$this->_role = UserRole::forUser($this);
		return $this->_role;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isAdmin()
	{
		return $this->getType() == UserType::ADMIN;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isResearcher()
	{
		return $this->getType() == UserType::RESEARCHER;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isReviewer()
	{
		return $this->getType() == UserType::REVIEWER;
	}
	
	/**
	 * 
	 * @return MessageBox
	 */
	public function getMessageBox()
	{
		if(!$this->_messageBox)
			$this->_messageBox = MessageBox::findByUser($this);
		return $this->_messageBox;
	}
	
	/**
	 * send a message to this user
	 * @param Message $msg
	 * @return Message the message that has been sent
	 */
	public function sendMessage($msg)
	{
		return $msg->sendTo($this);
	}
	
	protected function validate(array &$errors)
	{
		if(!self::isValidUsername($this->username)){
			$errors[] = ValidationError::USER_USERNAME_INVALID;
		}
		if(!self::isValidPassword($this->password)){
			$errors[] = ValidationError::USER_PASSWORD_INVALID;
		}
		if(!self::isValidEmail($this->email)){
			$errors[] = ValidationError::USER_EMAIL_INVALID;
		}
		if(static::findByUsername($username)){
			$errors[] = ValidationError::USER_USERNAME_UNAVAILABLE;
		}
		if(static::findByEmail($this->email)){
			$errors[] = ValidationError::USER_EMAIL_UNAVAILABLE;
		}
		if(empty($this->first_name)){
			$errors[] = ValidationError::USER_FIRST_NAME_EMPTY;
		}
		if(empty($this->last_name)){
			$errors[] = ValidationError::USER_LAST_NAME_EMPTY;
		}
		if(!UserType::isValue((int) $this->type)){
			$errors[] = ValidationError::USER_TYPE_INVALID;
		}
		
		if((int) $this->type == UserType::RESEARCHER){
			if(empty($this->address)){
				$erros[] = ValidationError::USER_ADDRESS_EMPTY;
			}
			if(empty($this->residence)){
				$errors[] = ValidationError::USER_RESIDENCE_EMPTY;
			}
			if(empty($this->nationality)){
				$errors[] = ValidationError::USER_NATIONALITY_EMPTY;
			}
			if(UserGender::isValue((int) $this->gender)){
				$errors[] = ValidationError::USER_GENDER_INVALID;
			}
		}
		
		return true;
		
	}
	
	/**
	 * finds the user with the given username or email
	 * @param string $unameOrEmail username or email, the format of the string will indicate whether
	 * a search is made by email or by username
	 * @return User
	 */
	public static function findByUsernameOrEmail($unameOrEmail)
	{
		if(User::isValidEmail($unameOrEmail)){
			return static::findByEmail($unameOrEmail);
		}
		return static::findByUsername($unameOrEmail);
	
	}
	
	
	/**
	 * 
	 * @param string $username
	 * @return User
	 */
	public static function findByUsername($username)
	{
		return static::findOneByField("username", $username);
	}
	
	/**
	 * 
	 * @param string $email
	 * @return User
	 */
	public static function findByEmail($email)
	{
		return static::findOneByField("email", $email);
	}
	
	//CHECKS USED FOR VALIDATION
	
	/**
	 * 
	 * @param string $email
	 * @return boolean
	 */
	public static function isValidEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	/**
	 * 
	 * @param username $username
	 * @return boolean
	 */
	public static function isValidUsername($username)
	{
		return preg_match("/^[\w-]+/", $username) === 1;
	}

	/**
	 * 
	 * @param string $password
	 * @return boolean
	 */
	public static function isValidPassword($password)
	{
		
	}
	
	
	
	
}