<?php

class PasswordResetView extends BaseView
{
	
	public function render()
	{
		$this->data->pageTitle = "Password Reset";
		$this->data->pageHeading = "Password Reset";
		$this->data->pageContent = $this->read("form-password-reset");
		$this->showBase();
	}
	
}