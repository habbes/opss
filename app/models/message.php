<?php

/**
 * represents a message or notification used in the internal
 * messaging and notification system
 * @author Habbes
 *
 */
class Message extends DBModel
{
	protected $user_id;
	protected $subject;
	protected $date_sent;
	protected $read;
	protected $message;
	protected $sender_type;
	protected $other_parts;
	
	private $_user;
	
	/*
	 * _parts and _senderArgs are encoded as json when saved,
	 * and stored in column "other_parts"
	 */
	//attachments
	private $_parts;
	//metadata about the sender
	private $_senderArgs;
	
	/*
	 * checks whether json data has been loaded from file,
	 * non-db properties such as message look at this value
	 * to know whether to pull data from the json or whether
	 * it has already been retrieved
	 */
	private $_jsonLoaded = false;
	
	/**
	 * 
	 * @return Message
	 */
	public function send()
	{
		$this->date_sent = Utils::dbDateFormat(time());
		$ds = DIRECTORY_SEPARATOR;
		$json = new JsonObject();
		$json->senderArgs = $this->_senderArgs;
		$json->parts = $this->_parts;
		$this->other_parts = $json->encode();
		
		return $this->save();
		
	}
	
	/**
	 * 
	 * @param User $user
	 * @return Message
	 */
	public function sendTo($user)
	{
		$this->setUser($user);
		return $this->send();
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isRead()
	{
		return (boolean) $this->read;
	}
	
	/**
	 * 
	 * @param boolean $read
	 */
	public function setRead($read)
	{
		$this->read = (int) $read;
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
	 * @param User $user
	 */
	public function setUser($user)
	{
		$this->user_id = $user->getId();
		$this->_user = $user;
	}
	
	/**
	 * list of metadata about the sender
	 * @return array
	 */
	public function getSenderArgs()
	{
		$this->decodeOtherParts();
		return $this->_senderArgs;
	}
	
	/**
	 * metadata about the sender
	 * @param array $args
	 */
	public function setSenderArgs($args)
	{
		$this->_senderArgs = $args;
	}
	
	/**
	 * metadata about the sender
	 * @param string $arg
	 * @param string $value
	 */
	public function addSenderArg($arg, $value)
	{
		$this->_senderArg[$arg] = $value;
	}
	
	/**
	 * 
	 * @param string $msg
	 */
	public function setMessage($msg)
	{
		$this->message = $msg;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}
	
	/**
	 * @return array
	 */
	public function getParts()
	{
		$this->decodeOtherParts();
		return $this->_parts;
	}
	
	/**
	 * 
	 * @param array $parts
	 */
	public function setParts($parts)
	{
		$this->_parts = $parts;
	}
	
	/**
	 * 
	 * @param string $type
	 * @param array $args key/val pairs related to the specified type
	 */
	public function addPart($type, $args)
	{
		if(!$this->_parts)
			$this->_parts = array();
		array_push($this->_parts, ["type"=>$type, "args"=>$args]);
	}
	
	/**
	 * gets the json object with this message's data
	 * @param string $addReadState whether isRead should be included in the json
	 * @return JsonObject
	 */
	public function getJsonObject($addReadState = true)
	{
		$j = array();
		$j->id = $this->getId();
		$j->subject = $this->getSubject();
		$j->message = $this->getMessage();
		$j->dateSent = $this->getDateSent();
		$j->username = $this->getUser()->getUsername();
		$j->senderType = $this->getSenderType();
		$j->senderArgs = $this->getSenderArgs();
		$j->parts = $this->getParts();
		
		/*
		 * this info should not be stored in json file because it can changed
		 * but it should be included an the AJAX json response
		 */
		if($addReadState)
			$j->isRead = $this->isRead();		
		
		return new JsonObject($a);	
		
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getJsonString()
	{
		return $this->getJsonObject()->encode();
	}
	
	/**
	 * decode data in the other_parts column
	 */
	private function decodeOtherParts()
	{
		if($this->_jsonLoaded || !$this->isInDb())
			return;
		$json = JsonObject::decode($this->json);
		$this->_senderArgs = $json->senderArgs;
		$this->_parts = $json->parts;
		$this->_jsonLoaded = true;
	}
	
	/**
	 * 
	 * @param User $user
	 * @return array
	 */
	public static function findByUser($user)
	{
		return static::findAllByField("user_id", $user->getId());
	}
	
	/**
	 * find the message with given id to the given user
	 * @param User $user
	 * @param int $id
	 * @return Message
	 */
	public static function findByUserAndId($user, $id)
	{
		return static::findOne("user_id=? AND id=?", $user->getId(), $id);
	}
	
	
	
}