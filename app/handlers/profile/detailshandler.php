<?php

class DetailsHandler extends LoggedInHandler
{
	public function get()
	{
		$this->setSavedResultMessage();
		$this->renderView("profile/Details");
	}
	
}