<?php

class MessageHandler extends LoggedInHandler
{
	
	private function showPage()
	{
		$this->setSavedResultMessage();
		$this->renderView("Messages");
	}
	
	public function get()
	{
		$this->viewParams->scope = "all";
		//TODO use order by in model to return in descending order
		$this->viewParams->messages = array_reverse($this->user->getMessageBox()->getAll());
		$this->showPage();
	}
	
	public function getUnread()
	{
		$this->viewParams->scope = "unread";
		$this->viewParams->messages = array_reverse($this->user->getMessageBox()->getUnread());
		$this->showPage();
	}
	
	public function ajaxRead($id)
	{
		$box = $this->user->getMessageBox();
		$message = $box->getById($id);
		if(!$message){
			header("HTTP/1.1 404 Not found");
			die("Error");
		}
		$message->setRead(true);
		$message->save();
		$this->viewParams->message = $message;
		$this->viewParams->unreadCount = $box->countUnread();
		$this->renderView("MessageAjax");
	}
	
	public function ajaxNew()
	{
		//long poll new messages
		
		//release session file to avoid blocking other requests
		session_write_close();
		$limit = 40;
		$started = time();
		set_time_limit($limit + 3);//+ grace period
		$box = $this->user->getMessageBox();
		while(time() - $started < $limit){
			$messages = $box->getNew();
			if(count($messages) > 0){
				$this->viewParams->messages = $messages;
				$this->viewParams->unreadCount = $box->countUnread();
				$this->renderView("NewMessagesAjax");
				exit;
			}
			sleep(1);
		}
		$this->viewParams->messages = [];
		$this->viewParams->unreadCount = $box->countUnread();
		$this->renderView("NewMessagesAjax");
	}
}