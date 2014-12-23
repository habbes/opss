<?php

/**
 * class that keeps track of the logged-user and
 * stores arbitrary data set for the login session,
 * data which is deleted when the user logs out
 * @author Habbes
 *
 */
class Login
{
	
	private static $user;
	
	/**
	 * 
	 * @return Session
	 */
	public static function session()
	{
		return Session::getInstance();
	}
	
	/**
	 * stores the login session for the specified user
	 * @param User $user
	 */
	public static function userLogin($user)
	{
		self::session()->login = new DataObject();
		self::session()->login->user_id = $user->getId();
		self::$user = $user;
	}
	
	/**
	 * get the currently logged in user
	 * @return User
	 */
	public static function getUser()
	{
		if(!self::$user)
			self::$user = User::findById(
					self::session()->login->user_id);
		return self::$user;
	}
	
	/**
	 * get the role of the current logged in user
	 * @return UserRole
	 */
	public static function getRole()
	{
		return self::getUser()->getRole();
	}
	
	/**
	 * checks whether a user is logged in
	 * @return boolean
	 */
	public static function isLoggedIn()
	{
		return self::session()->login? true : false;
	}
	
	/**
	 * retrieves data from the login session
	 * @param string $name
	 * @return mixed
	 */
	public static function get($name)
	{
		return self::session()->login->get($name);
	}
	
	/**
	 * adds data to the login session
	 * @param name $name
	 * @param mixed $value
	 */
	public static function set($name, $value)
	{
		self::session()->login->set($name, $value);
	}
	
	/**
	 * logs the user out of this session, also removes
	 * all data stored in the login session
	 * (the rest of the session remains intact)
	 */
	public static function logout()
	{
		unset(self::session()->login);
	}
}