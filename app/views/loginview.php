<?php
class LoginView extends View
{
	public function render($params)
	{
		$this->data->pageTitle = "AERC_OPSS | LogIn";
		$this->data->body = $this->read("form-login");
		$this->show("base");
	}
}