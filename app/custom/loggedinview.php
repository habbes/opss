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
	 */
	public function showBase()
	{
		switch(Login::getUser()->getType()){
			case UserType::RESEARCHER:
				$data->pageNav = $this->read("researcher-nav");
				break;
			case UserType::REVIEWER:
				$data->pageNav = $this->read("reviewer-nav");
				break;
			case UserType::ADMIN:
				$data->pageNav = $this->read("admin-nav");
				break;
			
		}
		
		parent::showBase();
	}
	
}