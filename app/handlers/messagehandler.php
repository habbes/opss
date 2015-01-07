<?php

class MessageHandler extends LoggedInHandler
{
	public function get()
	{
		$this->viewParams->scope = "all";
		$this->viewParams->notifications = [];
		$this->renderView("Messages");
	}
}