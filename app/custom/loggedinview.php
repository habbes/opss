<?php

/**
 * base class for views that display pages in the member's area (that require a
 * user to be logged in)
 * @author Habbes
 *
 */
class LoggedInView extends BaseView
{
	
	/**
	 * display the page on top of the mainlayout
	 * and show the correct navigation panel based on the
	 * role of the logged-in user
	 * @params DataObject $params params passed by the controller
	 */
	public function showBase($params)
	{
		$this->data->userName = $params->user->getFullName();
		switch($params->user->getType()){
			case UserType::RESEARCHER:
				$this->data->pageNav = $this->read("researcher-nav");
				break;
			case UserType::REVIEWER:
				$this->data->pageNav = $this->read("reviewer-nav");
				break;
			case UserType::ADMIN:
				$this->data->pageNav = $this->read("admin-nav");
				break;
			
		}
		
		
		parent::showBase();
	}
	
}