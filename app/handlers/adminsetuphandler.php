<?php

class AdminSetupHandler extends LoggedOutHandler
{
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		
	}
	
	private function showPage()
	{
		$this->renderView("AdminSetup");
	}
}