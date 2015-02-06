<?php

class ScheduleWorkshopHandler extends PaperHandler
{
	
	public function getAllowedRoles()
	{
		return [UserType::ADMIN];
	}
	
	public function showPage()
	{
		$this->viewParams = Workshops::findAll();
		$this->renderView("papers/Home");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		try
		{
			$workshop = Workshop::findById($this->trimPostVar("workshop"));
			if(!$workshop)
				throw new OperationException(["WorkshopNotFound"]);
			$this->paper->addToWorkshopQueue($workshop);
			$this->paper->save();
			$this->saveResultMessage("Paper added to presentation pipeline successfully.", "success");
			$this->paperLocalRedirect();
		}
		catch(OperationException $e)
		{
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case "WorkshopNotFound":
						$errors->workshop = "The specified workshop was not found.";
						break;
				}
			}
			
			$this->viewParams->scheduleWorkshopErrors = $errors;
			$this->viewParams->scheduleWorkshopForm = new DataObject($_POST);
			$this->setResultMessage("Please correct the highlighted errors and try again.", "error");
			$this->showPage();
		}
	}
}