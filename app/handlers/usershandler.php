<?php
class Usershandler extends AdminHandler{
	
	
	public function getResearchers(){
		$this->viewParams->researchers = Researcher::findAll(); 
		$this->setSavedResultMessage();
		$this->renderView("Researchers");
	}
	public function getReviewers(){
		$this->viewParams->reviewers = Reviewer::findAll();
		$this->setSavedResultMessage();
		$this->renderView("Reviewers");
	}
	public function getAdmins(){
		$this->viewParams->admins = Admin::findAll();
		$this->setSavedResultMessage();
		$this->renderView("Admins");
	}
	private function showpage(){
		
	}
}