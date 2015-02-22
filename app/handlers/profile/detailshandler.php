<?php

class DetailsHandler extends LoggedInHandler
{
	public function get()
	{
		$this->renderView("profile/Details");
	}
}