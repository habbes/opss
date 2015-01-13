<?php

class SubmitPaperView extends LoggedInView
{
	public function render()
	{
		if(!$this->data->form){
			$this->data->form = new DataObject();
		}
		if(!$this->data->errors){
			$this->data->errors = new DataObject();
		}
		$this->setActiveNavLink("Papers", "Submit");
		$this->data->pageHeading = "Submit Paper";
		$this->data->pageTitle = "Submit Paper";
		$this->data->pageContent = $this->read("form-paper-submission");
		$this->showBase();
	}
}