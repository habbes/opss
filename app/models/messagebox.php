<?php

class MessageBox extends DBModel
{
	protected static $table = "message_boxes";
	
	protected $user_id;
	protected $last_query_time;
	
	private $_user;
	
	/**
	 * creates a MessageBox for the specified User
	 * @param User $user
	 * @return MessageBox
	 */
	public static function create($user)
	{
		$m = new static();
		$m->user_id = $user->getId();
		$m->_user = $user;
		$m->last_query_time = Utils::dbDateFormat(time());
		
		return $m;
	}
	
	/**
	 * 
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
	 * get the last time messages were queried from this message box
	 * @return string
	 */
	public function getLastQueryTime()
	{
		return strftime($this->last_query_time);
	}
	
	/**
	 * 
	 * @param int $time timestamp
	 */
	public function setLastQueryTime($time)
	{
		$this->last_query_time = Utils::dbDateFormat(time());
	}
	
	
	/**
	 * update the last query time of this message box to the current time
	 */
	public function updateQueryTime()
	{
		$this->setQueryTime(time());
		$this->save();
	}
	
	
	/**
	 * get all messages in this message box
	 * @return array
	 */
	public function getAll()
	{
		$msgs = Message::findByUser($this->getUser());
		$this->updateQueryTime();
		return $msgs;
	}
	
	/**
	 * get the message with the given id
	 * @param int $id
	 * @return Message
	 */
	public function getById($id)
	{
		return Message::findOne("user_id=? AND id=?", [$this->user_id, $id]);
	}
	
	/**
	 * get all messages in this message box using the given query filters
	 * @param string $query
	 * @param array $vals
	 * @param array $options
	 * @return array(Message)
	 */
	public function getAllByQuery($query, $vals, $options = [])
	{
		$query = "user_id=? AND $query";
		array_unshift($vals, $this->user_id);
		return Message::findAll($query, $vals, $options);
	}
	
	/**
	 * get all messages with the given sender type
	 * @param string $type
	 * @return array(Message)
	 */
	public function getBySenderType($type)
	{
		return $this->getAllByQuery("sender_type='?", [$type]);
	}
	
	/**
	 * get all unread messages in this message box
	 * @return array(Message)
	 */
	public function getUnread()
	{
		$msgs = $this->getAllByQuery("is_read=?", [(int) false]);
		$this->updateQueryTime();
		return $msgs;
	}
	
	/**
	 * get all unread messages with the given sender type in this message
	 * @param string $type
	 * @return array(Message)
	 */
	public function getUnreadBySenderType($type)
	{
		return $this->getAllByQuery("is_read=? AND sender_type='?'",[(int) false, $type]);
	}
	
	/**
	 * get new messages (all those sent after the last query time)
	 * @return array(Message)
	 */
	public function getNew()
	{
		$msgs =  $this->getAllByQuery("date_sent >= ?", [$this->last_query_time]);
		$this->updateQueryTime();
		return $msgs;
	}
	
	
	/**
	 * find the message box belonging to the specified user
	 * @param User $user
	 * @return MessageBox
	 */
	public static function findByUser($user)
	{
		return static::findOneByField("user_id", $user->getId());
	}
}