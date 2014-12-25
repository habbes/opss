<?php

class LoginView extends View
{
	public function render($params)
	{	
		$this->data->pageTitle = "Log In";
		$this->data->pageHeading = "Log In";
		$this->data->pageBody = $this->read("form-login");
		$this->show("base");
	}
}