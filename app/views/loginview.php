<?php

class LoginView extends BaseView
{
	public function render($params)
	{	
		$this->data->loadData($params->toArray());
		$this->data->pageTitle = "Log In";
		$this->data->pageHeading = "Log In";
		$this->data->pageContent = $this->read("form-login");
		$this->showBase();
	}
}