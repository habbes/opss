<?php

class HomeHandler extends PaperHandler
{
	private function showPage()
	{
		if($this->paper->getStatus() == Paper::STATUS_VETTING_REVISION){
			//TODO create a method to get latest vetReview from paper: $paper->findLatestVetReview
			$vrs = VetReview::findByPaper($this->paper);
			$this->viewParams->vetReview = array_pop($vrs);
		}
		
		if($this->paper->getStatus() == Paper::STATUS_PENDING){
			foreach($this->paper->getNextActions() as $action){
				switch($action){
					case Paper::ACTION_EXTERNAL_REVIEW:
						$this->viewParams->reviewers = Reviewer::findAll();
						$this->viewParams->reviewRequests = $this->paper->getValidReviewRequests();
						$this->viewParams->reviewInvitations = RegInvitation::findValidByPaper($this->paper);
						break;
					
					case Paper::ACTION_WORKSHOP_QUEUE:
						$this->viewParams->workshops = Workshop::findAll();
						break;
				}
			}
		}
		
		if($this->session()->resultMessage){
			$this->setResultMessage($this->session()->resultMessage, $this->session()->resultMessageType);
			$this->session()->deleteData("resultMessage");
			$this->session()->deleteData("resultMessageType");
		}
		
		$this->renderView("papers/Home");
	}
	
	public function get()
	{
		$this->showPage();	
	}
	
	public function handleVetReview()
	{
		$this->viewParams->form = new DataObject($_POST);
		try {
			if($group = $this->trimPostVar("group")){
				$this->paper->setThematicArea($group);
				$this->paper->save();
			}
			$vet = VetReview::create($this->paper);
			$vet->setComments($this->trimPostVar("comments"));
			$verdict = "";
			
			if(isset($_POST[VetReview::VERDICT_REJECTED])){
				$verdict = VetReview::VERDICT_REJECTED;
			}
			else if(isset($_POST[VetReview::VERDICT_ACCEPTED])){
				$verdict = VetReview::VERDICT_ACCEPTED;
			}
			
			$vet->submit($this->user, $verdict);
			PaperChange::createVetted($this->paper, $vet)->save();
			//notify researcher
			PaperVettedMessage::create($this->paper, $vet->getVerdict(), $this->paper->getResearcher())->send();
			
			//TODO send email notification to researcher
			
			//notify admins
			foreach(Admin::findAll() as $admin){
				PaperVettedMessage::create($this->paper, $vet->getVerdict(), $admin)->send();
			}
			
			//redirect to paper home
			$this->localRedirect("/papers/".$this->paper->getIdentifier());
		}
		catch(OperationException $e)
		{
			$this->viewParams->errors = new DataObject();
			$this->setResultMessage("Please correct the highlighted errors.", "error");
			foreach($e->getErrors() as $error){
				switch($error){
					case OperationError::PAPER_THEMATIC_AREA_INVALID:
						$this->viewParams->errors->group = "Invalid group selected.";
						break;
					case OperationError::VET_INVALID_VERDICT:
						$this->viewParams->errors->verdict = "Invalid verdict selected.";
						break;
					case OperationError::VET_COMMENTS_EMPTY:
						$this->viewParams->errors->comments = "Please enter comments.";
						break;
				}
			}
			
		}
		
		$this->showPage();
	}
}