<?php

class RegistrationView extends BaseView
{
	public function render($params)
	{
		$this->data->pageContent = $this->read("form-registration");
		$this->showBase();
	}
}