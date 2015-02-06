<?php

class AllWorkshopsHandler extends AdminHandler
{
	public function get()
	{
		$this->setSavedResultMessage();
		$this->viewParams->workshops = Workshop::findAll();
		$this->renderView("AllWorkshops");
	}
}