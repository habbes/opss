<?php
class HomeHandler extends LoggedInHandler
{
	public function get()
	{
		$this->show();
	}
	private function show()
	{
		$this->renderView("Home");
	}
}