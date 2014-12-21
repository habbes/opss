<?php
class SubmitHandler extends RequestHandler
{
	public function show()
	{
		//$this->viewParams->form = "this is a test";
		$this->renderView("submit");
	}
	public function get()
	{
		$this->show();
	}
}