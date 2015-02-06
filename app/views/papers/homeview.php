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
			case Paper::STATUS_PENDING:
				if($this->data->user->isAdmin()){
					$this->addPaperPendingActionsAdmin();
				}
				if($this->data->user->isResearcher()){
					$this->addPaperPendingNoticeResearcher();
				}
				
				break;
			
			case Paper::STATUS_REVIEW:
				if($this->data->user->isAdmin()){
					$this->data->reviewer = $this->data->paper->getCurrentReviewer();
					$this->data->review = $this->data->paper->getCurrentReview();
					$this->addHomePageItem("paper-review-notice-admin");
				}
				if($this->data->user->isResearcher()){
					$this->addHomePageItem("paper-review-notice-researcher");
				}
				if($this->data->user->isReviewer()){
					$this->addHomePageItem("paper-review-form");
				}
				break;
			case Paper::STATUS_REVIEW_SUBMITTED:
				if($this->data->user->isAdmin()){
					$this->data->review = $this->data->paper->getRecentlySubmittedReview();
					$this->data->reviewer = $this->data->review->getReviewer();
					$this->addHomePageItem("paper-review-submitted-admin");
					
				}
				if($this->data->user->isResearcher()){
					$this->addPaperPendingNoticeResearcher();
				}
				break;
			case Paper::STATUS_REVIEW_REVISION_MAJ:
			case Paper::STATUS_REVIEW_REVISION_MIN:
				if($this->data->user->isAdmin()){
					$this->data->review = $this->data->paper->getRecentlySubmittedReview();
					$this->addHomePageItem("paper-review-revision-notice-admin");
				}
				if($this->data->user->isResearcher()){
					$this->data->review = $this->data->paper->getRecentlySubmittedReview();
					$this->addHomePageItem("paper-review-revision-researcher");
				}
				break;
			case Paper::STATUS_WORKSHOP_QUEUE:
				if($this->data->user->isAdmin()){
					$this->data->workshop = $this->data->paper->getWorkshop();
					$this->addHomePageItem("paper-workshop-queue-admin");
				}
				if($this->data->user->isResearcher()){
					$this->data->workshop = $this->data->paper->getWorkshop();
					$this->addHomePageItem("paper-workshop-queue-notice-researcher");
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
	
	private function addPaperPendingActionsAdmin()
	{
		$this->addHomePageItem("paper-pending-actions-admin");
	}
	
	private function addPaperPendingNoticeResearcher()
	{
		$this->addHomePageItem("paper-pending-notice-researcher");
	}
	
}