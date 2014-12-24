<?php

/**
 * stores data on the current session
 * @author Habbes
 *
 */
class Session extends DataObject {

	private static $instance = null;

	public function __construct(){
		session_start();
		if(!isset($_SESSION["data"])){
			$_SESSION["data"] = array();
			$_SESSION["startIp"] = $_SERVER["REMOTE_ADDR"];
			$_SESSION["startTime"] = time();
		}
		$this->data = &$_SESSION["data"];
		$_SESSION["lastTime"] = time();
		$_SESSION["lastIp"] = $_SERVER["REMOTE_ADDR"];
	}
	
	/**
	 * gets the current session
	 * @return Session
	 */
	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * deletes all data stored in the session as well as its cookie
	 * @return boolean
	 */
	public function destroy(){
		//delete all session vars
		$_SESSION = array();

		//delete session cookie
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
		$params['path'], $params['domain'],
		$params['secure'], $params['httponly']
		);

		//destroy session data
		return session_destroy();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DataObject::set()
	 */
	public function set($name, $val = true)
	{
		parent::set($name, $val);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DataObject::get()
	 */
	public function get($name)
	{
		if(array_key_exists($name, $_SESSION)){
			return $_SESSION[$name];
		}
		else {
			return parent::get($name);
		}
	}

	public function __get($name){
		return $this->get($name);
	}
	
	
	
	/**
	 * gets the seconds this session has been alive
	 * @return number
	 */
	public function age(){
		return $_SESSION["lastTime"] - $_SESSION["startTime"];
	}
	
	/**
	 * gets whether the IP used for this request is the same as the
	 * last IP that made a request on this session
	 * @return boolean
	 */
	public function sameIp(){
		return $_SESSION["lastIp"] == $_SESSION["startIp"];
	}
	
	/**
	 * deletes the specified info from the session
	 * @param string $key
	 */
	public function deleteData($key){
		unset($_SESSION["data"][$key]);
	}
	
	
	public static function __callStatic($method, $args)
	{
		return call_user_func_array([self::getInstance(), $method], $args);
	}
	

}
