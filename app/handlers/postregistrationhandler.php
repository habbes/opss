<?php

class PostRegistrationHandler extends LogoutHandler
{
	private function showPage()
	{
		$this->renderView("PostRegistration");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		
	}
}