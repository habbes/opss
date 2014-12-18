<?php
class FormHandler extends RequestHandler
{
	public function show()
	{
		$this->viewParams->form = "this is a test";
		$this->renderView("Form");
	}
	public function get()
	{
		$this->show();
	}
}