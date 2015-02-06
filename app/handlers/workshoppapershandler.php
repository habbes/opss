<?php

class WorkshopPapersHandler extends AdminHandler
{
	
	/**
	 * 
	 * @var Workshop
	 */
	private $workshop;
	
	private function showPage()
	{
		$this->viewParams->workshop = $this->workshop;
		$this->renderView("WorkshopPapers");
	}
	
	private function checkWorkshop($month, $year)
	{
		$month = Workshop::getMonthNumber($month);
		$this->workshop = Workshop::findByMonthAndYear($month, $year);
		if(!$this->workshop){
			$this->saveResultMessage("The specified workshop was not found.", "error");
			$this->localRedirect("workshops/all");
		}
	}
	
	public function get($month, $year)
	{
		$this->checkWorkshop($month, $year);
		$this->showPage();
	}
	
	public function post()
	{
		$this->checkWorkshop($month, $year);
		$this->showPage();
	}
}