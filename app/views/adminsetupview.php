<?php

class AdminSetupView extends BaseView
{
	public function render($params)
	{
		$this->pageContent = $this->read("admin-form-registration");
		$this->showBase();
	}
}