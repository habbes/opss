<?php

/**
 * base handlers for pages that display user profile details
 * @author Habbes
 *
 */
class UserHandler extends AdminHandler
{
	/**
	 * 
	 * @var User
	 */
	protected $user;
	
	protected function userLocalRedirect($url = "")
	{
		if(substr($url, 0, 1) != "/") $url = "/$url";
		$this->localRedirect("users/".$this->user->getUsername().$url);
	}
	
	public function onCreate()
	{
		$username = func_get_arg(0);
		$user = User::findByUsername($username);
		if(!$user){
			$this->saveResultMessage("The specified user was not found.", "error");
			$this->localRedirect("users/all");
		}
		$this->user = $user;
		parent::onCreate();
		$this->viewParams->selectedUser = $user;
		$this->viewParams->userBaseUrl = $user->getAbsoluteUrl();
	}
}