<?php

class SubmitView extends View
{
	public function render($params)
	{	
		$this->data->pageTitle = "Submit";
		$this->data->pageHeading = "Submit: Researcher";
		$this->data->userName = "Mr Clement";
		$this->data->countries = $params->countries;
		$this->data->pageContent = $this->read("form-proposal-submission");
		$this->data->pageNav = $this->read("researcher-nav");
		$this->data->pageBody = $this->read("main-layout");
		$this->show("base");
	}
}