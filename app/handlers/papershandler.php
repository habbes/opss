<?php

class PapersHandler extends RoleHandler
{
	protected function getAllowedRoles()
	{
		return [UserType::ADMIN, UserType::RESEARCHER, UserType::REVIEWER];
	}
	
	private function showPage()
	{
		$this->viewParams->papers = $this->role->getPapers();
		$this->renderView("AllPapers");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function searchPaper()
	{
		$query = $this->trimGetVar("q");
		if($query)
			$papers = Paper::findAll("title like ? OR identifier like ?",["%$query%", "%$query%"]);
		else
			$papers = Paper::findAll();
		$this->viewParams->papers = $papers;
		$this->renderView("PaperSearch");
	}
}