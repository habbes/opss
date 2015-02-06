<?php

class AllWorkshopsView extends LoggedInView
{
	public function render()
	{
		$this->data->pageTitle = "All Workshops";
		$this->data->pageHeading = $this->data->pageTitle;
		$this->setActiveNavLink("Workshops", "All Workshops");
		$this->data->pageContent = $this->read("workshops-table");
		$this->showBase();
	}
}