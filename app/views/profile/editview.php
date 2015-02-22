<?php

class EditView extends LoggedInView
{
	public function render()
	{
		$this->data->pageTitle = "Edit Account Details";
		$this->data->pageHeading = "Edit Account Details";
		if($this->data->user->isResearcher())
			$this->data->pageContent = $this->read("form-edit-profile-researcher");
		else
			$this->data->pageContent = $this->read("form-edit-profile-admin");
		
		$this->showBase();
	}
}