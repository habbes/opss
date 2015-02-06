<?php

class WorkshopPapersView extends LoggedInView
{
	public function render()
	{
		$this->data->pageHeading = "Workshop: ". $this->data->workshop->toString();
		$this->data->pageTitle = $this->data->pageHeading;
		$this->setActiveNavLink("Workshops", "AllWorkshops");
		$this->data->pageContent = $this->read("workshop-papers-table");
		$this->showBase();
	}
}