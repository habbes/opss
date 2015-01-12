<?php
class HomeView extends LoggedInView
{
	public function render($params)
	{
		//$this->data->userName = $params->userName;
		$this->data->pageTitle = "Home";
		$this->data->pageHeading = "Home";
		$this->data->pageContent = $this->read("table");
		$this->showBase($params);
	}
}