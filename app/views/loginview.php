<?php
class LoginView extends BaseView
{
	public function render($params)
	{
		$this->data->pageTitle = "AERC_OPSS | Log in";
		$this->data->pageContent = $this->read("form-login");
		//$this->data->nav = $this->read("admin-nav");
		$this->show($template);
	}
}