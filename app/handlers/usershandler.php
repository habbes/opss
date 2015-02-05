<?php
class Usershandler extends AdminHandler{
	public function getResearchers(){
		$this->viewParams->researchers = Researcher::findAll(); 
		$this->renderView("Researchers");
	}
	public function getReviewers(){
		$this->viewParams->reviewers = Reviewer::findAll();
		$this->renderView("Reviewers");
	}
	public function getAdmins(){
		$this->viewParams->admins = Admin::findAll();
		$this->renderView("Admins");
	}
	private function showpage(){
		
	}
}