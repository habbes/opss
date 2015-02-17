<?php

class MessageAjaxView extends View
{
	public function render()
	{
		$response = new JsonObject();
		$response->subject = $this->data->message->getSubject();
		$response->body = $this->read("message-content");
		$response->unreadCount = $this->data->unreadCount;
		$response->sendResponse();
	}
}