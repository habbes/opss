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
	
	public function ajaxRead($id)
	{
		$message = $this->user->getMessageBox()->getById($id);
		if(!$message){
			header("HTTP/1.1 404 Not found");
			die("Error");
		}
		$message->setRead(true);
		$message->save();
		$this->viewParams->message = $message;
		$this->renderView("MessageAjax");
	}
}