<?php

class ResubmitHandler extends PaperHandler
{
	public function post()
	{
		switch($this->paper->getStatus()){
			case Paper::STATUS_VETTING_REVISION:
				$this->vettingResubmit();
				break;
			
			case Paper::STATUS_REVIEW_REVISION_MAJ:
			case Paper::STATUS_REVIEW_REVISION_MIN:
				$this->reviewResubmit();
				break;
			case Paper::STATUS_POST_WORKSHOP_REVISION_MIN:
				$this->workshopReviewResubmitMin();
				break;
			case Paper::STATUS_POST_WORKSHOP_REVISION_MAJ:
				$this->workshopReviewResubmitMaj();
				break;
				
		}
	}
	
	private function sendNotificationMessages()
	{
		//notify reseracher
		PaperResubmittedMessage::create($this->paper, $this->paper->getResearcher())->send();
		
		//notify admins
		foreach(Admin::findAll() as $admin){
			PaperResubmittedMessage::create($this->paper, $admin)->send();
		}
	}
	
	public function vettingResubmit()
	{
		$this->paper->vettingResubmit();
		PaperChange::createResubmitted($this->paper)->save();
		
		//notification messages
		$this->sendNotificationMessages();
		//TODO send notification emails
		
		$this->saveResultMessage("Paper resubmitted successfully.", "success");
		$this->paperLocalRedirect();
	}
	
	public function reviewResubmit()
	{
		$this->paper->reviewResubmit();
		PaperChange::createResubmitted($this->paper)->save();
		
		//notification messages
		$this->sendNotificationMessages();
		//TODO send notification emails
		
		$this->saveResultMessage("Paper resubmitted successfully.", "success");
		$this->paperLocalRedirect();
	}
	
	public function workshopReviewResubmitMin()
	{
		$this->paper->workshopReviewResubmitMin();
		PaperChange::createResubmitted($this->paper)->save();
		
		//notification messages
		$this->sendNotificationMessages();
		//TODO send notification emails
		
		$this->saveResultMessage("Paper resubmitted successfully.", "success");
		$this->paperLocalRedirect();
	}
	
	public function workshopReviewResubmitMaj()
	{
		$this->paper->workshopReviewResubmitMaj();
		PaperChange::createResubmitted($this->paper)->save();
	
		//notification messages
		$this->sendNotificationMessages();
		//TODO send notification emails
	
		$this->saveResultMessage("Paper resubmitted successfully.", "success");
		$this->paperLocalRedirect();
	}
}