<?php

class TestView extends MainLayoutView
{
	public function render()
	{
		$this->data->errors = new DataObject();
		$this->data->form = new DataObject();
		$this->data->pageTitle = "Upload";
		$this->data->pageHeading = "Upload | Researcher";
		$this->data->userName = "Mr Clement";
		$this->data->pageContent = $this->read("admin-form-registration");
		$this->showBase();
	}
}