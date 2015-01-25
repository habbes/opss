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
}