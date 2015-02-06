<?php

class ScheduleWorkshopView extends LoggedInView
{
	public function render()
	{
		$this->data->pageHeading = "Schedule Workshop";
		$this->data->pageTitle = $this->data->pageHeading;
		$this->setActiveNavLink("Workshops", "Schedule Workshop");
		$this->data->pageContent = $this->read("schedule-workshop-form");
		$this->showBase();
	}
}