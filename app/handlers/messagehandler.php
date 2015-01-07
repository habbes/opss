<?php

class MessageHandler extends LoggedInHandler
{
	public function get()
	{
		$this->viewParams->scope = "all";
		$this->viewParams->messages = $this->user->getMessageBox()->getAll();
		$this->renderView("Messages");
	}
}