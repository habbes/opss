<?php

class Notification extends DBModel
{
	protected $user_id;
	protected $subject;
	protected $date_sent;
	protected $read;
	protected $file_id;
	protected $sender_type;
	
	private $_user;
	private $_file;
	private $_parts;
	private $_message;
	private $_senderArgs;
	
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
	 * @return File
	 */
	public function getFile()
	{
		if(!$this->_file)
			$this->_file = File::findById($this->file_id);
		return $this->_file;
	}
	
	public function setMessage($msg)
	{
		$this->_message = $msg;
	}
	
	public function getMessage()
	{
		return $this->_message;
	}
	
	public function getParts()
	{
		return $this->_parts;
	}
}