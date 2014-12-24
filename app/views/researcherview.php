<?php
class ResearcherView extends View
{
	public function render($params)
	{
		$this->data->pageTitle = "AERC_OPSS | Researcher";
		$this->data->pageBody = $this->read("main-layout");
		$this->data->nav = $this->read("researcher-nav");
		$this->showBase();
	}
}