<?php
class SubmitHandler extends ResearcherHandler
{
	public function show()
	{
		//$this->viewParams->form = "this is a test";
		$this->viewParams->countries = file(DIR_SYS_DATA.DIRECTORY_SEPARATOR."countries-en", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
		$this->renderView("submit");
	}
	public function get()
	{
		$this->show();
	}
}