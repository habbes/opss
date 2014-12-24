<?php
class ResearcherView extends View
{
	public function render($params)
	{
		//$this->data->userName = $params->userName;
		$this->data->pageTitle = "AERC_OPSS | Researcher";
		$this->data->pageHeading = "Researcher";
		$this->data->userName = $params->userName;
		$this->data->pageNav = $this->read("researcher-nav");
		$this->data->pageContent = "You have successifully logged in";
		$this->data->pageBody = $this->read("main-layout");
		$this->show("base");
	}
}