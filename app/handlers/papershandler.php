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
		$filterFields = ['country', 'language', 'region', 'level', 'thematic_area', 'status', 'level'];
		$country = $this->trimGetVar('country');
		
		$filters = (boolean) $this->trimGetVar('filters');
		
		if($query || $filters){
			$role = $this->role;
			
			$searchQuery = "title like ? OR identifier like ?";
			$searchFilters = "";
			$searchParams = ["%$query%", "%$query%"];
			
			// add filters to query and their values in the param array
			foreach($filterFields as $i=>$field){
				if($i != 0){
					$searchFilters .= " AND ";
				}
				$value = $this->trimGetVar($field);
				if($value){
					$searchFilters .= "$field LIKE ?";
				}
				else{
					// if value is empty, match with either null or empty string
					$searchFilters .= "($field LIKE ? OR $field IS NULL)";
				}
				$searchParams[] = "%$value%";
			}
			
			$fullQuery = "($searchQuery) AND ($searchFilters)";
			
			
			$papers = Paper::findAll($fullQuery, $searchParams);
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