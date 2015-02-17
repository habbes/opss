<?php

class NewMessagesAjaxView extends View
{
	public function render()
	{
		$resp = new JsonObject();
		$msgs = [];
		foreach($this->data->messages as $msg){
			$msgs[] = [
					"id" => $msg->getId(),
					"subject"=>$msg->getSubject(),
					"date" => Utils::siteDateFormat($msg->getDateSent())
			];
		}
		$resp->messages = $msgs;
		$resp->unreadCount = $this->data->unreadCount;
		$resp->sendResponse();
	}
}