<?php

class HomeHandler extends UserHandler
{
	public function get()
	{
		$this->setSavedResultMessage();
		$this->renderView("users/Home");
	}
}