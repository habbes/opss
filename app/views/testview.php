<?php

class TestView extends View
{
	public function render($params)
	{
		$this->data->files = $params->files;
		$this->data->pageTitle = "Upload";
		$this->data->pageHeading = "Upload | Researcher";
		$this->data->userName = "Mr Clement";
		$this->data->pageContent = $this->read("test");
		$this->data->nav = $this->read("researcher-nav");
		$this->data->pageBody = $this->read("main-layout");
		//echo $this->data->pageBody; exit;
		$this->show("base");
	}
}