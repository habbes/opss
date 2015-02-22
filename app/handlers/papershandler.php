<?php

class PapersHandler extends RoleHandler
{
	protected function getAllowedRoles()
	{
		return [UserType::ADMIN, UserType::RESEARCHER, UserType::REVIEWER];
	}
	
	private function showPage()
	{
		$this->setSavedResultMessage();
		$this->viewParams->papers = $this->role->getPapers();
		$this->renderView("AllPapers");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function searchPaper()
	{
		//restrict search to admins
		//TODO: filter search results for different roles in advanced Searcher
		if(!$this->user->isAdmin())
			return;
		$query = $this->trimGetVar("q");
		if($query)
			$papers = Paper::findAll("title like ? OR identifier like ?",["%$query%", "%$query%"]);
		else
			$papers = Paper::findAll();
		$this->viewParams->papers = $papers;
		$this->renderView("PaperSearch");
	}
}