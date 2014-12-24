<?php

/**
 * base class for handlers for requests that a user be logged in
 * if there's no login session, it automatically redirects to the login
 * page before handling any requests
 * @author Habbes
 *
 */
class LoginHandler extends RequestHandler
{
	
	protected $user;
	protected $role;
	
	/**
	 * ensures a user is logged in before proceeding and redirects
	 * the user to the login page if not.
	 * It sets the user property to the logged-in user
	 */
	protected function assertLogin()
	{
		if(Login::isLoggedIn()){
			$this->user = Login::getUser();
			$this->role = Login::getRole();
			$this->viewParams->user = $this->user;
		}
		else {
			$this->localRedirect("login");
		}
	}
	
	public function onCreate()
	{
		$this->assertLogin();
	}
}