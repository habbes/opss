<?php

class TestView extends View
{
	public function render($params)
	{
		$this->data->files = $params->files;
		$this->data->errors = new DataObject();
		$this->data->form = new DataObject();
		$this->data->pageTitle = "Upload";
		$this->data->pageHeading = "Upload | Researcher";
		$this->data->userName = "Mr Clement";
		$this->data->pageContent = $this->read("admin-form-registration");
		$this->data->pageNav = $this->read("researcher-nav");
		$this->data->pageBody = $this->read("main-layout");
		//echo $this->data->pageBody; exit;
		$this->show("base");
	}
}