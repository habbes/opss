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
				
		}
	}
	
	public function vettingResubmit()
	{
		$this->paper->vettingResubmit();
		PaperChange::createResubmitted($this->paper)->save();
		//TODO: send notification messages & emails
		$this->saveResultMessage("Paper resubmitted successfully.", "success");
		$this->paperLocalRedirect();
	}
	
	public function reviewResubmit()
	{
		$this->paper->reviewResubmit();
		PaperChange::createResubmitted($this->paper)->save();
		//TODO: send notifications
		$this->saveResultMessage("Paper resubmitted successfully.", "admin");
		$this->paperLocalRedirect();
	}
}