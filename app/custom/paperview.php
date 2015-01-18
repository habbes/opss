<?php

/**
 * base class for views that display sub-pages of a paper's dashboard
 * @author Habbes
 *
 */
class PaperView extends LoggedInView
{
	
	protected $sidebarItems = [];
	protected $paperNavLinks = [];
	
	public function __construct($data)
	{
		parent::__construct($data);
		$this->setPaperNavLinks();
	}
	
	/**
	 * 
	 * @param string $template template module to include in the sidebar
	 */
	public function addSidebarItem($template)
	{
		$this->sidebarItems[] = $template;
	}
	
	public function setPaperNavLinks()
	{
		$this->paperNavLinks[] = (object) ["name"=>"Home","url"=>"","active"=>true, "visible"=>true];
		$this->paperNavLinks[] = (object) ["name"=>"Details","url"=>"details","active"=>false, "visible"=>false];
		$this->paperNavLinks[] = (object) ["name"=>"History","url"=>"history","active"=>false, "visible"=>true];
	}
	
	public function showPaperNavLink($name, $active = false)
	{
		foreach($this->paperNavLinks as $link){
			if($link->name == $name){
				$link->visible = true;
				if($active)
					$link->active = true;
				break;
			}
		}
	}
	
	public function setActivePaperNavLink($name)
	{
		foreach($this->paperNavLinks as $link){
			$link->active = $link->name == $name;
		}
	}
	
	public function getVisiblePaperNavLinks()
	{
		$links = [];
		foreach($this->paperNavLinks as $link){
			if($link->visible)
				$links[] = $link;
		}
	
		return $links;
	}
	
	public function showBase()
	{
		$paper = $this->data->paper;
		$this->data->pageTitle = sprintf("Paper %s: %s ", $paper->getRevisionIdentifier(), $paper->getTitle());
		$this->data->pageHeading = $this->data->pageTitle;
		$this->data->paperSidebarItems = $this->sidebarItems;
		$this->data->paperNavLinks = $this->getVisiblePaperNavLinks();
		$this->data->pageContent = $this->read("paper-layout");
		parent::showBase();
	}
}