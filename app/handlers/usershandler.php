<?php
class Usershandler extends AdminHandler{
	
	
	public function getResearchers(){
		$this->viewParams->researchers = Researcher::findAll(); 
		$this->setSavedResultMessage();
		$this->renderView("Researchers");
	}
	public function getReviewers()
	{
		$this->viewParams->reviewers = Reviewer::findAll();
		$this->setSavedResultMessage();
		$this->renderView("Reviewers");
	}
	
	public function searchReviewers()
	{
		$query = $this->trimGetVar("q");
		
		
		if($query){
			$this->viewParams->reviewers = Reviewer::find("first_name like ? OR last_name like ?",["%$query%", "%$query%"]);
				
		}
		else {
			$this->viewParams->reviewers = Reviewer::findAll();
		}
		
		$this->renderView("ReviewersSearch");
	}
	
	public function getAdmins(){
		$this->viewParams->admins = Admin::findAll();
		$this->setSavedResultMessage();
		$this->renderView("Admins");
	}
	private function showpage(){
		
	}
}