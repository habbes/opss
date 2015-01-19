<?php

class HomeView extends PaperView
{
	
	private $homePageItems = [];
	
	private function addHomePageItem($template)
	{
		$this->homePageItems[] = $this->read($template);
	}
	
	public function render()
	{
		
		switch($this->data->paper->getStatus()){
			case Paper::STATUS_VETTING:
				//TODO: instead of using isAdmin() create method in Role@canVetPaper($paper)
				if($this->data->user->isAdmin())
					$this->addVetReviewForm();
				//TODO: consider createing method in Role@isAuthor($paper) instead
				if($this->data->user->isResearcher())
					$this->addVettingNoticeForResearcher();
				break;
			case Paper::STATUS_VETTING_REVISION:
				if($this->data->user->isAdmin()){
					$this->addVetRevisionNoticeForAdmin();
				}
				if($this->data->user->isResearcher()){
					$this->addVetRevisionNoticeForResearcher();
				}
				
				break;
		}
		
		$this->setActivePaperNavLink("Home");
		$this->data->paperHomePageItems = $this->homePageItems;
		$this->data->paperPageContent = $this->read("paper-home");
		$this->showBase();
	}
	
	private function addVetReviewForm()
	{
		$this->data->form or $this->data->form = new DataObject();
		$this->data->errors or $this->data->errors = new DataObject();
		$this->addHomePageItem("paper-vet-review");
	}
	
	private function addVettingNoticeForResearcher()
	{
		$this->addHomePageItem("paper-in-vetting-researcher");
	}
	
	private function addVetRevisionNoticeForAdmin()
	{
		$this->addHomePageItem("paper-vetting-revision-notice-admin");
	}
	
	private function addVetRevisionNoticeForResearcher()
	{
		$this->addHomePageItem("paper-vetting-revision-notice-researcher");
	}
}