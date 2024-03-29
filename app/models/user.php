<?php
use Intervention\Image\ImageManagerStatic as Image;
Image::configure(['driver'=>'gd']);

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
	protected $timezone;
	
	protected $address;
	protected $residence;
	protected $nationality;
	protected $gender;
	
	protected $photo_id;
	
	private $_photo;
	private $_messageBox;
	private $_thematicAreas;
	private $_collaborativeAreas;
	private $_role;
	//used to store the password before it has been hashed
	//so it can be checked for validity before being saved to db
	private $_plainPassword = null;
	//used to check whether the username is being updated when the user is saved
	private $_newUsername = false;
	private $_newEmail = false;
	
	const PHOTO_DIR = "profile_pics";
	
	/**
	 * createa user of the given type/role
	 * @param int $type UserType
	 * @return User
	 */
	public static function create($type)
	{
		$u = new static();
		$u->type = $type;
		$u->email_activated = false;
		
		return $u;
	}
	
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
			$name = $this->title . " " . $name;
		return $name;
	}
	
	/**
	 * 
	 * @param string $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
		$this->_newUsername = true;
	}
	
	/**
	 * 
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
		$this->_newEmail = true;
		$this->email_activated = false;
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
		return (int) $this->gender;
	}
	
	/**
	 * 
	 * @param string $password
	 * @return boolean
	 */
	public function setPassword($password)
	{
		$this->_plainPassword = $password;
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
		$this->_plainPassword = $new;
		$this->password = Utils::hashPassword($new);
		return true;
	}
	
	/**
	 * add the specified research area to the list
	 * this user's areas of thematic research
	 * @param int $area PaperGroup
	 */
	public function addThematicArea($area)
	{
		if(!in_array($area, $this->getThematicAreas())){
			UserResearchArea::createThematic($this, $area);
			array_push($this->_thematicAreas, $area);
		}
	}
	
	/**
	 * remove all research areas from this user's list of areas of
	 * thematic research
	 */
	public function deleteAllThematicAreas()
	{
		foreach(UserResearchArea::findThematicByUser($this) as $area){
			$area->delete();
		}
		$this->_thematicAreas = [];
	}
	
	/**
	 * get all the areas of research for thematic papers for this
	 * user
	 * @return array(int) elements are from PaperGroup
	 */
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
	
	/**
	 * add the specified research area to this user's list of
	 * areas of collaborative research
	 * @param int $area PaperGroup
	 */
	public function addCollaborativeArea($area)
	{
		if(!in_array($area, $this->getCollaborativeAreas())){
			UserResearchArea::createCollaborative($this, $area);
			array_push($this->_collaborativeAreas, $area);
		}
	}
	
	/**
	 * remove all research areas from this user's list of areas of
	 * collaborative research
	 */
	public function deleteAllCollaborativeAreas()
	{
		foreach(UserResearchArea::findCollaborativeByUser($this) as $area){
			$area->delete();
		}
		$this->_collaborativeAreas = [];
	}
	
	/**
	 * get all the areas of collaborative research for this user
	 * @return array(int) elements are from PaperGroup
	 */
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
	 * gets the profile picture of the user
	 * @return File
	 */
	public function getPhoto()
	{
		if(!$this->_photo){
			$this->_photo = File::findById($this->photo_id);
		}
		return $this->_photo;
	}
	
	/**
	 * Set the profile picture of this user
	 * @param string $sourceFile
	 */
	public function setPhoto($sourceFile)
	{
		$image = Image::make($sourceFile)->resize(100,100)->encode("jpg");
		if($photo = $this->getPhoto()){
			$photo->overwriteFromContent((string) $image);
		}
		else {
			$ds = DIRECTORY_SEPARATOR;
			$dir = self::PHOTO_DIR.$ds.$this->getUsername();
			$file = File::createFromContent($dir, (string) $image);
			$file->setFilename("profile-pic.jpg");
			$file->save();
			$this->photo_id = $file->getId();
			$this->_photo = $file;
		}
	}
	
	/**
	 * gets the absolute url of the profile picture
	 * @return string
	 */
	public function getPhotoUrl()
	{
		return URL_ROOT ."/photo/".$this->username;
	}
	
	/**
	 * Outputs the profile photo to the browser
	 */
	public function sendPhotoResponse()
	{
		if($photo = $this->getPhoto()){
			header('Content-Type: image/jpg');
			header('Content-Length: '.$this->getPhoto()->getSize());
			echo $photo->getContent();
			exit;
		}
		else {
			die("");
		}
	}
	
	/**
	 * checks whether a user with the given credentials exists
	 * and returns that User, throws exception when login fails
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
			throw new OperationException([OperationError::USER_PASSWORD_INCORRECT]);
		}
		throw new OperationException([OperationError::USER_NOT_FOUND]);
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
	
	/**
	 * send this user an email
	 * @param Email $email
	 * @return number number of successfull emails sent
	 */
	public function sendEmail($email)
	{
		$email->addUser($this);
		return $email->send();
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getAbsoluteUrl()
	{
		return URL_ROOT ."/users/".$this->username;
	}
	
	
	protected function onInsert(&$errors = NULL)
	{
		
		$this->date_added = Utils::dbDateFormat(time());
		return true;
	}
	
	protected function afterInsert()
	{
		//create MessageBox for this user
		$mb = MessageBox::create($this);
		$this->_messageBox = $mb->save();
	}
	
	protected function validate(&$errors)
	{
		if(!self::isValidUsername($this->username)){
			$errors[] = OperationError::USER_USERNAME_INVALID;
		}
		
		if(!self::isValidEmail($this->email)){
			$errors[] = OperationError::USER_EMAIL_INVALID;
		}
		if($this->_newUsername && static::findByUsername($this->username)){
			$errors[] = OperationError::USER_USERNAME_UNAVAILABLE;
		}
		if($this->_newEmail && static::findByEmail($this->email)){
			$errors[] = OperationError::USER_EMAIL_UNAVAILABLE;
		}
		//if _plainPassword is not null, then the password has been changed or created
		if($this->_plainPassword !== null && !static::isValidPassword($this->_plainPassword)){
			$errors[] = OperationError::USER_PASSWORD_INVALID;
		}
		if(empty($this->first_name)){
			$errors[] = OperationError::USER_FIRST_NAME_EMPTY;
		}
		if(empty($this->last_name)){
			$errors[] = OperationError::USER_LAST_NAME_EMPTY;
		}
		if(!UserType::isValue((int) $this->type)){
			$errors[] = OperationError::USER_TYPE_INVALID;
		}
		
		if((int) $this->type == UserType::RESEARCHER){
			if(empty($this->address)){
				$erros[] = OperationError::USER_ADDRESS_EMPTY;
			}
			if(empty($this->residence)){
				$errors[] = OperationError::USER_RESIDENCE_EMPTY;
			}
			if(empty($this->nationality)){
				$errors[] = OperationError::USER_NATIONALITY_EMPTY;
			}
			if(!UserGender::isValue((int) $this->gender)){
				$errors[] = OperationError::USER_GENDER_INVALID;
			}
		}
		
		return true;
		
	}
	
	/**
	 * get all papers this user has access to
	 * @return array(Paper)
	 */
	public function getPapers()
	{
		return $this->getRole()->getPapers();
	}
	
	/**
	 * get all ongoing reviews by this reviewer
	 * @return array(Review)
	 */
	public function getCurrentReviews()
	{
		return Review::findCurrentByReviewer($this);
	}
	
	/**
	 * get all completed reviews by this reviewer
	 * @return array(Review)
	 */
	public function getCompletedReviews()
	{
		return Review::findCompletedByReviewer($this);
	}
	
	/**
	 * get all reviews by this reviewer
	 * @return array(Review)
	 */
	public function getReviews()
	{
		return Review::findByReviewer($this);
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
		return preg_match("/^[\w-]+$/", $username) === 1;
	}

	/**
	 * 
	 * @param string $password
	 * @return boolean
	 */
	public static function isValidPassword($password)
	{
		//upper/lower case, digits and special characters from the US keyboard
		return preg_match("/^[a-zA-Z0-9`~!@#\$%\^&\*\(\)\-_\+=\[\{\]\}\'\";:\\\|,<\.>\/\? ]{6,50}$/",$password);
	}
	
	
}