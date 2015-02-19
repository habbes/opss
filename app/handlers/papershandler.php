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
	
	public function searchPaper($query)
	{
		$this->viewParams->papers = Paper::findAll("title like '%?%'",[$query]);
		$this->renderView("PaperSearch");
	}
}