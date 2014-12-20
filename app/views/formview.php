<?php

class FormView extends View
{
	public function render($params)
	{	
		$this->data->pageTitle = "Testing";
		$this->data->pageHeading = "Testing";
		$this->data->pageContent = $this->read("test");
		$this->data->nav = $this->read("admin-nav");
		$this->data->pageBody = $this->read("main-layout");
		//echo $this->data->pageBody; exit;
		$this->show("base");
	}
}