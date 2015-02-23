<?php

class ScheduleWorkshopHandler extends AdminHandler
{
	private function showPage()
	{
		$this->viewParams->months = Workshop::getMonthStrings();
		$year = getdate(time())["year"];
		$this->viewParams->years = [$year, $year+1,$year+2,$year+3];
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
			$name = $this->trimPostVar("name");
			$workshop = Workshop::create($year, $month);
			if($name)
				$workshop->setName($name);
			$workshop->save();
			$this->saveResultMessage("Workshop scheduled successfully.", "success");
			$this->localRedirect("workshops/".$workshop->getStringId());
			
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