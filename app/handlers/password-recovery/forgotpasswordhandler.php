<?php

class ForgotPasswordHandler extends LoggedOutHandler
{
	private function showPage()
	{
		$this->renderView("password-recovery/ForgotPassword");
	}
	
	public function get()
	{
		$this->showPage();
	}
}