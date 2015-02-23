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
		
		$query = $this->trimGetVar("q");
		if($query){
			$role = $this->role;
			$papers = Paper::findAll("title like ? OR identifier like ?",["%$query%", "%$query%"]);
			if(!$role->isAdmin()){
				//TODO: this is inefficient, implement role filtering in advanced searcher
				$papers = array_filter($papers, function($paper) use ($role){
					return $role->hasAccessToPaper($paper);
				});
			}
			
		}
		else {
			$papers = $this->role->getPapers();
		}
		$this->viewParams->papers = $papers;
		$this->renderView("PaperSearch");
	}
}