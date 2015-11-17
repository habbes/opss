<?php

class PipelineHandler extends AdminHandler
{
	private function showPage()
	{
		$this->viewParams->papers = Paper::findInPresentationPipeline();
		$this->renderView('Pipeline');
		
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