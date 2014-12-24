<?php

class RegistrationHandler extends RequestHandler
{
	private function showPage()
	{
		$this->renderView("Registration");
	}
	
	public function get()
	{
		$this->showPage();
	}
}