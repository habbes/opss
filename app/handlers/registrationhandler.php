<?php

class RegistrationHandler extends RequestHandler
{
	private function showPage()
	{
		$this->viewParams->countries = SysDataList::get("countries-en");
		$this->viewParams->titles = SysDataList::get("titles-en");
		$this->viewParams->languages = SysDataList::get("languages-en");
		$this->viewParams->researchAreaValues = sort(array_keys(PaperGroup::getValues()));
		$this->viewParams->researchAreaNames = PaperGroup::getValues();
		$this->renderView("Registration");
	}
	
	public function get()
	{
		$this->showPage();
	}
}