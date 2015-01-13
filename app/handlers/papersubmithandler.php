<?php

class PaperSubmitHandler extends ResearcherHandler
{
	
	public function showPage()
	{
		$this->viewParams->countries = SysDataList::get("countries-en");
		$this->viewParams->languages = SysDataList::get("languages-en");
		$this->renderView("SubmitPaper");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		
		$this->showPage();
	}
}