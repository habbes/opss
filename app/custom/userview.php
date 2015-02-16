<?php

class UserView extends LoggedInView
{
	protected $userNavLinks = [];
	
	public function __construct($data)
	{
		parent::__construct($data);
		$this->setUserNavLinks();
	}
	
	public function setUserNavLinks()
	{
		$this->userNavLinks[] = (object) ["name"=>"Details","url"=>"","active"=>false];
		if($this->data->selectedUser->isResearcher()){
			$this->userNavLinks[] = (object) ["name"=>"Papers Submitted","url"=>"papers-submitted","active"=>false];
		}
		if($this->data->selectedUser->isReviewer()){
			$this->userNavLinks[] = (object) ["name"=>"Papers Reviewing","url"=>"papers-reviewing","active"=>false];
			$this->userNavLinks[] = (object) ["name"=>"All Reviews","url"=>"all-reviews","active"=>false];
		}

	}
	
	public function showUserNavLink($name, $active = false)
	{
		foreach($this->userNavLinks as $link){
			if($link->name == $name){
				$link->visible = true;
				if($active)
					$link->active = true;
				break;
			}
		}
	}
	
	public function setActiveUserNavLink($name)
	{
		foreach($this->userNavLinks as $link){
			$link->active = $link->name == $name;
		}
	}
	
	public function getVisibleUserNavLinks()
	{
		return $this->userNavLinks;
	}
	
	public function showBase()
	{
		$user = $this->data->selectedUser;
		$this->data->pageTitle = sprintf("%s : %s ", $user->getFullName(), UserType::getString($user->getType()));
		$this->data->pageHeading = $this->data->pageTitle;
		$this->data->userNavLinks = $this->userNavLinks;
		$this->data->pageContent = $this->read("user-layout");
		parent::showBase();
	}
}