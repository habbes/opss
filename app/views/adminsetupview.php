<?php

class AdminSetupView extends BaseView
{
	public function render($params)
	{
		if(!$params->form)
			$params->form = new DataObject();
		if(!$params->errors)
			$params->errors = new DataObject();
		$this->data->loadData($params->toArray());
		$this->data->pageContent = $this->read("admin-form-registration");
		$this->showBase();
	}
}