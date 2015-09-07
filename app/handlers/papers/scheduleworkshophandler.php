<?php

class ScheduleWorkshopHandler extends PaperHandler
{
	
	public function getAllowedRoles()
	{
		return [UserType::ADMIN];
	}
	
	public function showPage()
	{
		$this->viewParams->workshops = Workshop::findAll();
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
			$this->saveResultMessage("Paper added to workshop queue successfully.", "success");
			$this->paperLocalRedirect();
		}
		catch(OperationException $e)
		{
			$errors = new DataObject();
			$msgSet = false;
			foreach($e->getErrors() as $error){
				switch($error){
					case "WorkshopNotFound":
						$errors->workshop = "The specified workshop was not found.";
						break;
					case OperationError::PAPER_NOT_PENDING:
						$this->setResultMessage("The paper must be pending in order to be added to a workshop queue.", "error");
						$msgSet = true;
						break;
					case OperationError::PAPER_ALREADY_IN_WORKSHOP:
						$this->setResultMessage("The paper has already been added to a workshop review queue.", "error");
						$msgSet = true;
						break;
						
				}
			}
			
			$this->viewParams->scheduleWorkshopErrors = $errors;
			$this->viewParams->scheduleWorkshopForm = new DataObject($_POST);
			if(!$msgSet)
				$this->setResultMessage("Please correct the highlighted errors and try again.", "error");
			$this->showPage();
		}
	}
}