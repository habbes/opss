<?php

/**
 * base class for handlers for requests that a user be logged in
 * if there's no login session, it automatically redirects to the login
 * page before handling any requests
 * @author Habbes
 *
 */
class LoggedInHandler extends BaseHandler
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
			$destination = $_SERVER['REQUEST_URI'];
			$this->localRedirect("login?destination=$destination");
		}
	}
	
	/**
	 * logout the current user
	 */
	public function logout()
	{
		Login::logout();
	}
	
	public function onCreate()
	{
		$this->assertLogin();
		//get badge values for unread counts
		if($this->user->isAdmin()){
			$this->viewParams->badgeUnreadPapers = Paper::countUnread();
		}
		if($this->user->isReviewer()){
			$this->viewParams->badgePendingRequests = ReviewRequest::countValidByReviewer($this->user);
		}
		//TODO: find most effective way of displaying new message count without conflicting with running alerts, if necessary
		//$this->viewParams->badgeNewNotifications = $this->user->getMessageBox()->countNew();
		$this->viewParams->badgeUnreadNotifications = $this->user->getMessageBox()->countUnread();
	}
}