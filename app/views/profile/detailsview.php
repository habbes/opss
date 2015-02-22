<?php

class DetailsView extends LoggedInView
{
	
	public function render()
	{
		$this->data->pageHeading = "Account Details";
		$this->data->pageTitle = "Account Details";
		$this->data->pageContent = $this->read("profile-details");
		$this->showBase();
	}
}