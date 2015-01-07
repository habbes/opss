<?php

class MessageHandler extends LoggedInHandler
{
	
	private function showPage()
	{
		$this->renderView("Messages");
	}
	
	public function get()
	{
		$this->viewParams->scope = "all";
		$this->viewParams->messages = $this->user->getMessageBox()->getAll();
		$this->showPage();
	}
	
	public function getUnread()
	{
		$this->viewParams->scope = "unread";
		$this->viewParams->messages = $this->user->getMessageBox()->getUnread();
		$this->showPage();
	}
}