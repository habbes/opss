<?php

class LoginView extends BaseView
{
	public function render()
	{	
		$this->data->pageTitle = "Sign In";
		$this->data->pageHeading = "Sign In";
		$this->data->pageContent = $this->read("form-login");
		$this->showBase();
	}
}