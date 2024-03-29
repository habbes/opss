<?php

/**
 * base class for handlers for pages for viewing and manipulating a paper
 * @author Habbes
 *
 */
abstract class PaperHandler extends RoleHandler
{
	
	/**
	 * 
	 * @var Paper
	 */
	protected $paper;
	
	protected function getAllowedRoles()
	{
		//by default, a paper page is accessible to any role who has access to the paper
		//restriction on role may be enforced by overriding this method
		return [UserType::ADMIN, UserType::REVIEWER, UserType::RESEARCHER];
	}
	
	/**
	 * indicates whether this particular sub-page of the paper dashboard should be visible,
	 * if not, the user will be redirected to the paper's home page
	 * @return boolean
	 */
	protected function isPageVisible()
	{
		return true;
	}
	
	/**
	 * redirects relatively to the root/home page of the current paper
	 * @param string $url
	 */
	protected function paperLocalRedirect($url = "")
	{
		if(substr($url, 0, 1) != "/") $url = "/$url";
		$this->localRedirect("papers/".$this->paper->getIdentifier().$url);
	}
	
	/**
	 * ensures the user has access to this paper and redirects otherwise
	 */
	protected function assertPaperAccess()
	{
		if(!$this->user->getRole()->hasAccessToPaper($this->paper)){
			$this->localRedirect("");
		}
		if(!$this->isPageVisible()){
			$this->localPaperRedirect("");
		}
	}
	
	public function onCreate()
	{
		$identifier = func_get_arg(0);
		$paper = Paper::findByIdentifier($identifier);
		if(!$paper){
			$this->saveResultMessage("The specified paper could not be found.", "error");
			$this->localRedirect("papers/all");
		}
		$this->paper = $paper;
		parent::onCreate();
		$this->assertPaperAccess();
		$this->viewParams->paper = $paper;
		$this->viewParams->paperBaseUrl = URL_PAPERS . "/" . $this->paper->getIdentifier();
		//mark as read if admin is accessing page
		if($this->user->isAdmin() && !$this->paper->hasBeenViewedByAdmin()){
			if(!$this->paper->hasBeenViewedByAdmin()){
				$this->paper->setViewedByAdmin(true);
				$this->paper->save();
			}
			//update unread count
			$this->viewParams->badgeUnreadPapers -= 1;
		}
		
	}
}