<?php

class ForgotPasswordView extends BaseView
{
	public function render()
	{
		$this->data->pageTitle = "Password Recovery";
		$this->data->pageHeading = "Password Recovery";
		$this->data->pageContent = $this->read("form-forgot-password");
		$this->showBase();
	}
}