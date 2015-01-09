<?php

/**
 * represents a role for a user based on the user's type
 * the role indicates what a user can or cannot do, what
 * the user has access to
 * @author Habbes
 *
 */
abstract class UserRole
{
	protected $user;
	protected static $type;
	
	/**
	 * 
	 * @param User $user
	 */
	protected function __construct($user)
	{
		$this->user = $user;
	}
	
	/**
	 * gets a role for the user based on its type
	 * @param User $user
	 * @return UserRole
	 */
	public static function forUser($user)
	{
		switch($user->getType())
		{
			case UserType::RESEARCHER:
				return new Researcher($user);			
			case UserType::REVIEWER:
				return new Reviewer($user);			
			case UserType::ADMIN:
				return new Admin($user);
		}
	}
	
	/**
	 * 
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}
	
	/**
	 * @return int UserType
	 */
	public function getType()
	{
		return static::$type;
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
	public function isReviewer()
	{
		return $this->getType() == UserType::REVIEWER;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isResearcher()
	{
		return $this->getType() == UserType::RESEARCHER;
	}
	
	//ABSTRACT METHODS
	
	/**
	 * find all users with this role
	 * @return array(User)
	 */
	public static function findAll()
	{
		return User::findAllByField("type", static::$type);
	}
	
	/**
	 * @return boolean
	 */
	public abstract function hasResidence();
	/**
	 * @return boolean
	 */
	public abstract function hasNationality();
	/**
	 * @return boolean
	 */
	public abstract function hasAddress();
	/**
	 * @return boolean
	 */
	public abstract function hasGender();
	
}