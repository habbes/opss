<?php

class ScheduleWorkshopHandler extends AdminHandler
{
	private function showPage()
	{
		$this->viewParams->months = Workshop::getMonthStrings();
		$this->viewParams->years = [2015, 2016, 2017, 2018];
		$this->renderView("ScheduleWorkshop");
	}
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		try {
			
			$month = (int) $this->trimPostVar("month");
			$year = (int) $this->trimPostVar("year");
			$workshop = Workshop::create($year, $month);
			$workshop->save();
			$this->setResultMessage("Workshop scheduled successfully.", "success");
			$this->showPage();
			
		}
		catch(OperationException $e){
			$errors = new DataObject();
			$exists = false;
			foreach($e->getErrors() as $error)
			{
				switch($error){
					case OperationError::WORKSHOP_MONTH_EMPTY:
						$errors->month = "Please specify month.";
						break;
					case OperationError::WORKSHOP_MONTH_INVALID:
						$errors->month = "Invalid choice for month.";
						break;
					case OperationError::WORKSHOP_YEAR_EMPTY:
						$errors->year = "Please specify year.";
						break;
					case OperationError::WORKSHOP_EXISTS:
						$exists = true;
						break;
				}
			}
			$this->viewParams->form = new DataObject($_POST);
			$this->viewParams->errors = $errors;
			if($exists)
				$this->setResultMessage("A workshop has already been scheduled for the selected time.", "error");
			else
				$this->setResultMessage("Please correct the highlighted errors.", "error");
			$this->showPage();
		}
	}
}