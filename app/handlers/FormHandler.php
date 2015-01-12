<?php
class FormHandler extends RequestHandler
{
	public function show()
	{
		//$this->viewParams->form = "this is a test";
		$this->viewParams->countries = file(DIR_SYS_DATA.DIRECTORY_SEPARATOR."countries-en", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
		$this->renderView("Form");
	}
	
	public function get()
	{
		$this->show();
	}
}