<?php

class EditHandler extends PaperHandler
{
	
	private function showPage()
	{
		$this->viewParams->countries = SysDataList::get("countries-en");
		$this->viewParams->languages = SysDataList::get("languages-en");
		$this->renderView("papers/Edit");
	}
	
	public function get()
	{
		$this->showPage();
	}
}