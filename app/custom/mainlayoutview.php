<?php

/**
 * base class for views with layout made of nav sidebar at left col and main content at right col
 * @author Habbes
 *
 */
class MainLayoutView extends BaseView
{
	
	protected $navLinks = array();
	
	
	/**
	 * display the page on top of the mainlayout
	 * and show the correct navigation panel based on the
	 * role of the logged-in user
	 * @params DataObject $params params passed by the controller
	 */
	public function showBase($params)
	{
		$user = $params->user;
		$this->data->userName = $user->getFullName();
		$role = $user->getRole();
		
		$this->addNavGroup("Notifications","envelope");
		$this->addNavLink("Notifications", "All Notifications", URL_ROOT."/messages/all");
		$this->addNavLink("Notifications", "Unread", URL_ROOT."/messages/unread");
		$this->addNavGroup("Papers","file");
		if($user->isResearcher())
			$this->addNavLink("Papers", "Submit", URL_ROOT."/papers/submit");
		$this->addNavLink("Papers","All Papers",URL_ROOT."/papers/all");
		
		if($user->isAdmin()){
			$this->addNavGroup("Users", "user");
			$this->addNavLink("Users", "Invite User", URL_ROOT."/papers/users/invite");
			$this->addNavLink("Users", "All Users", URL_ROOT."/papers/users/all");
			$this->addNavLink("Users", "Researchers", URL_ROOT."/papers/users/researchers");
			
		}
		
		$this->data->navLinks = $this->navLinks;
		$this->data->pageNav = $this->read("nav");
		parent::showBase($params);
	}
	
	/**
	 * adds a navigation subgroup (e.g. Users, Papers)
	 * @param string $name
	 * @param string $icon
	 */
	protected function addNavGroup($name, $icon)
	{
		$this->navLinks[] = ["name"=>$name, "icon"=>$icon, "links"=>[]];
	}
	
	/**
	 * 
	 * @param string $groupName the subgroup under which to place the link
	 * @param string $name displayed name of the link
	 * @param string $url
	 */
	protected function addNavLink($groupName, $name, $url)
	{
		$count = count($this->navLinks);
		for($i = 0;$i < $count;  $i++)
		{
			if($this->navLinks[$i]["name"] == $groupName){
				$this->navLinks[$i]["links"][] = new DataObject(["name"=>$name, "url"=>$url, "active"=>false]);
				break;
			}
		}
	}
	
	/**
	 * select the nav link that is active, that corresponds to the current page
	 * @param string $groupName name of the subgroup
	 * @param string $linkName display name of the link
	 */
	protected function setActiveNavLink($groupName, $linkName)
	{
		foreach($this->navLinks as $group)
		{
			if($group["name"] == $groupName){
				foreach($group["links"] as $link){
					if($link->name == $linkName){
						$link->active = true;
						break;
					}
				}
				break;
			}
		}
	}
}