<?php

class FormView extends View
{
	public function render($params)
	{	
		$this->data->pageTitle = "Register";
		$this->data->pageHeading = "Register: Researcher";
		$this->data->userName = "Mr Clement";
		$this->data->pageContent = $this->read("form-login");
		//$this->data->nav = $this->read("admin-nav");
		$this->data->pageBody = $this->read("main-layout");
		//echo $this->data->pageBody; exit;
		$this->show("base");
	}
}