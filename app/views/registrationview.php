<?php

class RegistrationView extends BaseView
{
	public function render($params)
	{
		$this->data->loadData($params->toArray());
		$this->data->pageTitle = "Registration";
		$this->data->pageHeading = "Registration";
		$this->data->pageContent = $this->read("form-registration");
		$this->showBase();
	}
}