<?php

class SubmitView extends MainLayoutView
{
	public function render()
	{	
		$this->data->pageTitle = "Submit";
		$this->data->pageHeading = "Submit: Researcher";
		$this->data->pageContent = $this->read("form-proposal-submission");
		$this->showBase();
	}
}