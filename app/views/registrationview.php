<?php

class RegistrationView extends BaseView
{
	public function render()
	{
		if(!$this->data->form)
			$this->data->form = new DataObject();
		if(!$this->data->errors)
			$this->data->errors = new DataObject();
		$this->data->pageTitle = "Registration";
		$this->data->pageHeading = "Registration";
		$this->data->pageContent = $this->read("form-registration");
		$this->showBase();
	}
}