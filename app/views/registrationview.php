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
		$formTemplate = $this->data->formType == "admin"? 
			"admin-form-registration" : "form-registration";
		$this->data->pageContent = $this->read($formTemplate);
		$this->showBase();
	}
}