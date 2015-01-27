<?php

/**
 * base handler for requests that require that no user be logged in
 * or the user is automatically redirected to the home page
 * @author Habbes
 *
 */
class LoggedOutHandler extends BaseHandler
{

	/**
	 * ensure the no user is logged in,
	 * if there is a login session available, then send
	 * the user to the home page
	 */
	protected function assertLogout()
	{
		if(Login::isLoggedIn()){
			$this->localRedirect("");
		}
	}
	
	/**
	 * creates a login session for the specified user
	 * @param User $user
	 */
	public function login($user)
	{
		Login::userLogin($user);
	}
	
	public function onCreate()
	{
		$this->assertLogout();
	}
}