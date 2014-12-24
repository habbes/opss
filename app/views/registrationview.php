<?php

class RegistrationView extends View
{
	public function render($params)
	{
		$this->data->pageContent = $this->read("form-registration");
		$this->data->pageBody = $this->read("main-layout");
		$this->show("base");
	}
}