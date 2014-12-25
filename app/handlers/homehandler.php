<?php
class HomeHandler extends LoggedInHandler
{
	public function get()
	{
		$this->showPage();
	}
	
	private function showPage()
	{
		$this->renderView("Home");
	}
}